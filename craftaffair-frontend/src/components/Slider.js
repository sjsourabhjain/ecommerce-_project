import React from 'react';

function Slider(props){
    return(
        <div className="carousel-item">
            <img src={props.imgUrl} alt="Los Angeles" className="sliderImage"/>
        </div>
    )
}

export default Slider;