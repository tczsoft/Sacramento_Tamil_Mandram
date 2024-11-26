import React, { useEffect, useState } from 'react'
import Form from '../../Shared/Components/Form/Form'
import AboutUs from '../../Shared/Components/About/AboutUs'
import { useLocation, useNavigate } from 'react-router-dom';

function FormPage() {
    const location = useLocation();
    const [activeSection, setActiveSection] = useState('register');
    const [isLoading, setIsLoading] = useState(false);
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        firstName: '',
        lastName: '',
        email: '',
        phoneNumber: '',
        event: '',
        participantName: '',
        agree: false,
    });
    const [volunteerData, setVolunteerData] = useState({
        name: '',
        email: '',
        phone: '',
        event: '',
        comments: '',
    });
    useEffect(() => {
        if (location.state && location.state.section) {
            setActiveSection(location.state.section);
        }
    }, [location.state]);

    const handleRegisterChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };
    const handleVolunteerChange = (e) => {
        const { name, value } = e.target;
        setVolunteerData(prev => ({ ...prev, [name]: value }));
    };
    useEffect(() => {
        if (location.state?.section === 'volunteer' && location.state?.eventName) {
            setVolunteerData(prev => ({ ...prev, event: location.state.eventName }));
        }
    }, [location.state]);
    const handleRegisterSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setTimeout(() => {
            setIsLoading(false);
            navigate('/payment-page');
        }, 2000);
    };
    const handleVolunteerSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);

        setTimeout(() => {
            setIsLoading(false);
            alert('Volunteer form submitted successfully!');
            setVolunteerData({
                name: '',
                email: '',
                phone: '',
                event: '',
                comments: '',
            });
        }, 2000);
    };
    return (
        <>
            <AboutUs title="Sports Fest" />
            <Form activeSection={activeSection}  formData={formData} handleVolunteerSubmit={handleVolunteerSubmit} handleRegisterSubmit={handleRegisterSubmit} handleRegisterChange={handleRegisterChange} handleVolunteerChange={handleVolunteerChange} volunteerData={volunteerData} isLoading={isLoading} />
        </>
    )
}

export default FormPage
