import React from 'react'
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Link } from 'react-router-dom';
import apiurl from '../../services/apiendpoint/apiendpoint';
function Gallery(props) {
  const { gallery, isLoading } = props;
  return (
    <>
      <section className=' max-w-[90rem] mx-auto   md:my-20  my-10'>
        <div>
          <div className='md:space-y-10 space-y-5'>
            <h2 className="text-2xl font-bold text-center text-[#504C00] md:text-4xl  concert-one-regular">GALLERY</h2>
            <section className="flex flex-col items-center relative   px-14 ">
              {isLoading ? (
                <Swiper
                  slidesPerView={1}
                  spaceBetween={30}
                  loop={true}
                  autoplay={{
                    delay: 3000,
                    disableOnInteraction: false,
                  }}
                  breakpoints={{
                    0: { slidesPerView: 1, },
                    768: { slidesPerView: 2, },
                    1024: { slidesPerView: 3, },
                  }}
                  navigation={{
                    nextEl: '.swiper-button-nextdea',
                    prevEl: '.swiper-button-prevdea',
                  }}
                  modules={[Pagination, Navigation, Autoplay]} className="w-full"  >
                  {Array(3).fill(0).map((_, index) => (
                      <SwiperSlide key={index} className="animate-pulse flex flex-col items-center">
                        <div className="w-full h-64 bg-gray-300 rounded-t-lg"></div>
                        <div className="w-full h-10  bg-gray-500  rounded-b-lg "></div>
                      </SwiperSlide>
                    ))}
                </Swiper>
              ) : (
                <Swiper
                  slidesPerView={1}
                  spaceBetween={30}
                  loop={true}
                  autoplay={{
                    delay: 3000,
                    disableOnInteraction: false,
                  }}
                  breakpoints={{
                    0: { slidesPerView: 1, },
                    768: { slidesPerView: 2, },
                    1024: { slidesPerView: 3, },
                  }}
                  navigation={{ nextEl: '.swiper-button-nextdea', prevEl: '.swiper-button-prevdea' }}
                  modules={[Pagination, Navigation, Autoplay]} className="w-full  " >
                  {gallery?.map((sponsor, index) => (
                    <SwiperSlide key={index} className="">
                      <Link to='/gallery'>
                        <div className='cursor-pointer  hover:scale-95 duration-200'>
                          <div className="flex items-center space-x-4  bg-[#EBE8A2] rounded-t-2xl">
                            <img src={`${apiurl()}/${sponsor.Image.split(',')[0]}`} className="bg-no-repeat mx-auto w-full rounded-2xl" />
                          </div>
                          <div className='text-center border rounded-br-2xl rounded-bl-2xl p-2 relative bottom-1  -z-10 text-[#504C00] font-bold md:text-2xl text-base bg-[#EBE8A2]'>
                            {sponsor.Year}
                          </div>
                        </div>
                      </Link>
                    </SwiperSlide>
                  ))}
                </Swiper>
              )}
              <div
                className="absolute  right-0   top-1/2  rotate-90  cursor-pointer"  >
                <img className=" swiper-button-nextdea px-2 w-14" src="/assets/images/Hero-Section/Top.png" alt="Previous" />
              </div>
              <div
                className="absolute  left-0 top-1/2   rotate-90 cursor-pointer">
                <img className=" swiper-button-prevdea px-2 w-14" src="/assets/images/Hero-Section/Bottom.png" alt="Next" />
              </div>
            </section>
          </div>
        </div>
      </section>
    </>
  )
}
export default Gallery
