<?php

namespace Models;

use MVC\Model;

class ModelsEvents extends Model {
    
    public function lastRecord($id) {
        $eventQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "events WHERE id = " . (int)$id);
        $eventData = $eventQuery->row;
        $result = [];
    
        if (!empty($eventData)) {
            $eventId = (int)$eventData['id'];
            $gamesQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "events_game WHERE id = $eventId");
            $eventData['Games'] = $gamesQuery->rows; 
            $result = $eventData;
        }
    
        return $result;
    }
    
    
    // public function getAll() {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "Events");
    //     return $query->rows;
    // }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "events");
        $events = $query->rows;
    
        if (!empty($events)) {
            foreach ($events as &$event) {
                $eventId = (int)$event['id'];
                $gamesQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "events_game WHERE id = $eventId");
                $event['Games'] = $gamesQuery->rows;
            }
        }
        return $events;
    }
    
    
    // public function save($data) {
    //     $keys = implode(",", array_keys($data));
    //     $values = "'" . implode("','", array_values($data)) . "'";
    //     $query = $this->db->query("INSERT INTO " . DB_PREFIX . "Events ($keys) VALUES ($values)");
    //     $id = $this->db->getLastId();
    //     return $this->lastRecord($id);
    // }

    public function save($data) {
        $eventData = [
            'Eventname' => $data['Eventname'],
            'Image' => $data['Image'],
            'Date' => $data['Date'],
            'Event_Time' => $data['Event_Time'],
            'Activities' => $data['Activities'] ?? '',
            'Poster_Type' => $data['Poster_Type'] ?? '',
            'Payment' => $data['Payment'] ?? '',
            'Guest_Count' => $data['Guest_Count'] ?? '',
            'Entry_Fees' => $data['Entry_Fees'] ?? '',
            'Fees_Adults' => $data['Fees_Adults'] ?? '',
            'Fees_Kids' => $data['Fees_Kids'] ?? '',
            'Fees_Under5' => $data['Fees_Under5'] ?? '',
            'Disclaimer' => $data['Disclaimer'] ?? '',
            'Description' => $data['Description'] ?? '',
            'Status' => $data['Status'] ?? 'Inactive', 
        ];
        $eventKeys = implode(",", array_keys($eventData));
        $eventValues = "'" . implode("','", array_values($eventData)) . "'";
        $this->db->query("INSERT INTO " . DB_PREFIX . "events ($eventKeys) VALUES ($eventValues)");
        
        $eventId = $this->db->getLastId();
    
        
        $games = is_string($data['Games']) ? json_decode($data['Games'], true) : $data['Games'];
        if (isset($games) && is_array($games)) {
            $gameValues = [];
            foreach ($games as $game) {
                $gameValues[] = "(" . (int)$eventId . ", '" . $this->db->escape($game['Game_Title']) . "', '" . $this->db->escape($game['Participant_Type']) . "', '" . $this->db->escape($game['GamePayment'] ?? null) . "', '" . $this->db->escape($game['Payment_Type'] ?? null) . "', '" . $this->db->escape($game['Entry_Fees'] ?? null) . "')";
            }
            if (!empty($gameValues)) {
                $gameInsertQuery = "INSERT INTO " . DB_PREFIX . "events_game (id, Game_Title, Participant_Type, GamePayment, Payment_Type, Entry_Fees) VALUES " . implode(", ", $gameValues);
                $this->db->query($gameInsertQuery);
            }
        }
    
        return $this->lastRecord($eventId);
    }
    
    
            
    public function Update($data, $id) {
        if (array_key_exists("id", $data)) {
            unset($data['id']);
        }
        $eventData = [
            'Eventname' => $data['Eventname'],
            'Image' => $data['Image'],
            'Date' => $data['Date'],
            'Event_Time' => $data['Event_Time'],
            'Activities' => $data['Activities'] ?? '',
            'Poster_Type' => $data['Poster_Type'] ?? '',
            'Payment' => $data['Payment'] ?? '',
            'Guest_Count' => $data['Guest_Count'] ?? '',
            'Entry_Fees' => $data['Entry_Fees'] ?? '',
            'Fees_Adults' => $data['Fees_Adults'] ?? '',
            'Fees_Kids' => $data['Fees_Kids'] ?? '',
            'Fees_Under5' => $data['Fees_Under5'] ?? '',
            'Disclaimer' => $data['Disclaimer'] ?? '',
            'Description' => $data['Description'] ?? '',
            'Status' => $data['Status'] ?? 'Inactive', 
        ];
        $cols = [];
        $values = [];
        foreach ($eventData as $key => $val) {
            $cols[] = "$key = ?";
            $values[] = $val;
        }
        $values[] = (int)$id;
        $query = "UPDATE " . DB_PREFIX . "events SET " . implode(', ', $cols) . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute($values)) {
            throw new Exception("Failed to update record.");
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "events_game WHERE id = " . (int)$id);
    
        $games = is_string($data['Games']) ? json_decode($data['Games'], true) : $data['Games'];
        if (isset($games) && is_array($games)) {
            $gameValues = [];
            foreach ($games as $game) {
                $gameValues[] = "(" . (int)$id . ", '" . $this->db->escape($game['Game_Title']) . "', '" . $this->db->escape($game['Participant_Type']) . "', '" . $this->db->escape($game['GamePayment'] ?? null) . "', '" . $this->db->escape($game['Payment_Type'] ?? null) . "', '" . $this->db->escape($game['Entry_Fees'] ?? null) . "')";
            }
            if (!empty($gameValues)) {
                $gameInsertQuery = "INSERT INTO " . DB_PREFIX . "events_game (id, Game_Title, Participant_Type, GamePayment, Payment_Type, Entry_Fees) VALUES " . implode(", ", $gameValues);
                $this->db->query($gameInsertQuery);
            }
        }
        return $this->lastRecord($id);
    }
    
    public function delete($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "events_game WHERE id = " . (int)$id);
        $this->db->query("DELETE FROM " . DB_PREFIX . "events WHERE id = " . (int)$id);
        return $id;
    }
    

    // public function Update($data, $id) {
    //     if (array_key_exists("id", $data)) {
    //         unset($data['id']);
    //     }
    //     $cols = [];
    //     $values = [];
    //     foreach ($data as $key => $val) {
    //         $cols[] = "$key = ?";
    //         $values[] = $val;
    //     }
    //     $query = "UPDATE " . DB_PREFIX . "Events SET " . implode(', ', $cols) . " WHERE id = ?";
    //     $values[] = (int)$id; 
    //     $stmt = $this->db->prepare($query); 
    //     if ($stmt->execute($values)) {
    //         return $this->lastRecord($id);
    //     } else {
    //         throw new Exception("Failed to update record.");
    //     }
    // }
    
    // public function delete($id) {
    //     $query = $this->db->query("DELETE FROM " . DB_PREFIX . "Events WHERE id = " . (int)$id);
    //     return $id;
    // }


}