import { LeftOutlined, RightOutlined } from "@ant-design/icons";
import { Button } from "antd";
import { FC, ReactNode } from "react";
import { Link } from "react-router-dom";
import Slider from "react-slick";
import './slick.css';
import './slick.theme.css';


export interface settingsType {
    dots: boolean,
    infinite: boolean,
    speed: number,
    autoplay: boolean,
    autoplaySpeed: number,
    slidesToShow: number,
    slidesToScroll: number,
    initialSlide: number
}

export interface prevNodeElement {
    prevArrow?: ReactNode;
    nextArrow?: ReactNode;
    customPaging?: (i: number) => ReactNode;
    arrows?: boolean;
}


export const settingTypeButtonPrev: prevNodeElement = {
    prevArrow: <Button ><LeftOutlined /></Button>,
    nextArrow: <Button > <RightOutlined /></Button>,
    customPaging: () => <button className="w-3 h-3 bg-gray-400 rounded-full" />,
    arrows: true
}


export interface ItemSlider {
    url: string | null,
    image: string,
    name: string | null
}

export const SlickSliderLazyLoad = (data: ItemSlider[]) => {

    const settings: settingsType = {
        dots: true,
        infinite: true,
        autoplay: false,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplaySpeed: 0,
        initialSlide: 2
    }

    return (
        <div className="slider-container overflow-hidden">
            <Slider {...settings}>
                {data && data.map(function (item) {
                    return (
                        <div className="h-[566px] relative w-full">
                            <Link to={item.url}>
                                <img src={item.image} alt={item.name} />
                            </Link>
                        </div>
                    )
                })}
            </Slider>
        </div >
    )
}


export const SliderAutoPlay: FC<{ data: ItemSlider[] }> = ({ data }) => {
    const settings: settingsType = {
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        speed: 1000,
        autoplaySpeed: 3000,
        initialSlide: 2,
        ...settingTypeButtonPrev
        // cssEase: "linear"
    }

    return (
        <div className="slider-container mx-auto overflow-hidden">
            <Slider {...settings}>
                {/* <div className="h-[566px] relative w-full">
                    <Link to={'/'}>
                        <img className="w-full object-cover" src='https://lh3.googleusercontent.com/BOn_mZdzhM-vDnaoLQbP-hoBeN6E5loAYQnuQcGsTX10-7ESeVF35VZeMAuWSctdf8lCXTTlzUPGhqCwb-66ElrRNa3Ma1ieYA=w1920-rw' loading="lazy" />
                    </Link>
                </div>
                <div className="h-[566px] relative w-full">
                    <Link to={'/'}>
                        <img className="w-full object-cover" src='https://lh3.googleusercontent.com/BOn_mZdzhM-vDnaoLQbP-hoBeN6E5loAYQnuQcGsTX10-7ESeVF35VZeMAuWSctdf8lCXTTlzUPGhqCwb-66ElrRNa3Ma1ieYA=w1920-rw' loading="lazy" />
                    </Link>
                </div>
                <div className="h-[566px] relative w-full">
                    <Link to={'/'}>
                        <img className="w-full object-cover" src='https://lh3.googleusercontent.com/BOn_mZdzhM-vDnaoLQbP-hoBeN6E5loAYQnuQcGsTX10-7ESeVF35VZeMAuWSctdf8lCXTTlzUPGhqCwb-66ElrRNa3Ma1ieYA=w1920-rw' loading="lazy" />
                    </Link>
                </div> */}
                {data && data.map(function (item) {
                    return (
                        <div className="h-[566px] relative w-full">
                            <Link to={item.url}>
                                <img src={item.image} className="w-full object-cover" alt={item.name} loading="lazy" />
                            </Link>
                        </div>
                    )
                })}
            </Slider>
        </div >
    )
}
