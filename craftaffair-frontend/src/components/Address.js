import React, { useState } from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import axios from 'axios';

function Address(){
    const userState = useSelector(state => state.user);
    const [ address, setAddressDetails ] = useState({
        user_id : 2,
        title : "",
        name : "",
        line_one : "",
        line_two : "",
        city : "",
        zipcode : "",
        phone : "",
        email : ""
    });
    const handleAdressInputChange = (e) => {
        setAddressDetails({
            ...address,
            [e.target.name] : e.target.value
        })
    }
    const navigate = useNavigate();
    const addAddress = () => {
        if(address.title==="" || address.name==="" || address.line_one==="" || address.line_two==="" || address.city==="" || address.zipcode==="" || address.phone==="" || address.email===""){
            alert("Please fill all fields");
        }else{
            axios.post(process.env.REACT_APP_BASE_URL + '/store-user-address',{...address, user_id : userState.userId },{
                headers: {
                    "Authorization" : `Bearer ${userState.authToken}`
                }
            }).then(function (response) {
                if(response.data.status===true){
                    alert("New address saved successfully");
                    navigate(routeConstants.INDEX_PAGE);
                }else{
                    alert(response.data.message);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

	return(
		<>
		<section className="checkout spad">
        <div className="container">
            <div className="checkout__form">
                <form action="#">
                    <div className="row">
                        <div className="col-lg-8 col-md-6">
                            <div className="row">
                                <div className="col-lg-6">
                                    <div className="checkout__input">
                                        <p>Title<span>*</span></p>
                                        <input onChange={handleAdressInputChange} name="title" value={address.title} placeholder="Title"/>
                                    </div>
                                </div>
                                <div className="col-lg-6">
                                    <div className="checkout__input">
                                        <p>Name<span>*</span></p>
                                        <input onChange={handleAdressInputChange} name="name" value={address.name} placeholder="Name"/>
                                    </div>
                                </div>
                            </div>
                            <div className="checkout__input">
                                <p>Address<span>*</span></p>
                                <input placeholder="Street Address" onChange={handleAdressInputChange} className="checkout__input__add"  name="line_one" value={address.line_one}/>
                                <input placeholder="Apartment, suite, unite ect (optinal)" onChange={handleAdressInputChange} name="line_two" value={address.line_two}/>
                            </div>
                            <div className	="row">
                            	<div className	="col-lg-6">
	                            	<div className="checkout__input">
	                                	<p>Town/City<span>*</span></p>
	                                	<input name="city" onChange={handleAdressInputChange} value={address.city} placeholder="Town/City"/>
	                                </div>
	                            </div>
	                            <div className	="col-lg-6">
		                            <div className="checkout__input">
		                                <p>Postcode / ZIP<span>*</span></p>
		                                <input name="zipcode" onChange={handleAdressInputChange} value={address.zipcode} placeholder="Zipcode"/>
		                            </div>
		                        </div>
	                        </div>
                            <div className	="row">
                                <div className	="col-lg-6">
                                    <div className	="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input name="phone" onChange={handleAdressInputChange} value={address.phone} placeholder="Phone"/>
                                    </div>
                                </div>
                                <div className="col-lg-6">
                                    <div className="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input name="email" onChange={handleAdressInputChange} value={address.email} placeholder="Email"/>
                                    </div>
                                </div>

                                <div className="col-lg-6">
                                    <div className="checkout__input">
                                        <button type="button" className='btn btn-primary' onClick={addAddress}>Add Address</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
		</>
	);
}

export default Address;