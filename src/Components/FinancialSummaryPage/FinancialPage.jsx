import React, { useCallback, useEffect, useState } from 'react'
import FinancialSummary from '../../Shared/Components/FinancialSummary/FinancialSummary'
import AboutUs from '../../Shared/Components/About/AboutUs';
// import { accordionItems } from '../../assets/Json/FinancialSummary';
import SponsorSwiper from '../../Shared/Components/SponsorSwiper/SponsorSwiper';
import { getallFinancialsum } from '../../Admin/shared/services/apifinancialsummary/apifinancialsummary';

function FinancialPage() {
    const [data, setData] = useState([]);
    const [openYear, setOpenYear] = useState(null);


    const fetchSponsors = useCallback(async () => {
        let isMounted = true; 
        try {
          const response = await getallFinancialsum(); 
          console.log(response)
          if (isMounted) {  setData(response);  }
        } catch (error) {
          console.error('Error fetching sponsors:', error);
        }
        return () => {
          isMounted = false; 
        };
  }, []);
  useEffect(() => { fetchSponsors();}, [fetchSponsors]);


  const groupedData = data.reduce((acc, item) => {
    acc[item.Year] = acc[item.Year] || [];
    acc[item.Year].push(item);
    return acc;
  }, {});
  

  const toggleYear = (year) => {
    setOpenYear(openYear === year ? null : year);
  };

  
    return (
        <>
            <AboutUs title="FINANCIAL SUMMARY" />
            <FinancialSummary data={data} openYear={openYear} groupedData={groupedData} toggleYear={toggleYear} />
            <SponsorSwiper />
        </>
    )
}
export default FinancialPage
