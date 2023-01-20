import React from 'react';

function Slider(props){
    return(
    	<section>
	        <div className="carousel-item">
	            <img src={props.imgUrl} alt="Los Angeles" className="sliderImage"/>
	        </div>
	    </section>
    )
}

export default Slider;