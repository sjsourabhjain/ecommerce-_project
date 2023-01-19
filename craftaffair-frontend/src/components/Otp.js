import React, { useState } from 'react';
import { useNavigate } from "react-router-dom";
import { routeConstants } from '../routeConstants';
import axios from 'axios';

const Otp = (props) =>{
    const navigate = useNavigate();
    const [registerDetails, setRegisterDetails] = useState({ mobile_no : props.mobile_no, otp : "", new_password : "" });
    const requestType = props.useType;

    const handleRegisterInputChange = (e) => {
        setRegisterDetails({
            ...registerDetails,
            [e.target.name] : e.target.value
        })
    }

    const verifyOTP = () => {
        if(requestType==="register" && (registerDetails.otp==="" || registerDetails.mobile_no==="")){
            alert("Please enter all the details");
        }else if(requestType==="forget_password" && (registerDetails.otp==="" || props.mobile_no==="" || registerDetails.new_password==="")){
            alert("Please enter all the details");
        }else{
            // send OTP to serve along with mobile no. for verification
            axios.post(process.env.REACT_APP_BASE_URL + '/verify-otp', {
                    mob_no: props.mobile_no,
                    otp: registerDetails.otp,
                    new_password : registerDetails.new_password,
                    type : requestType
                })
                .then(function (response) {
                    if(response.data.status===true){
                        alert(response.data.message);
                        navigate(routeConstants.INDEX_PAGE);
                    }else{
                        alert(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }

    return (
        <>
            <div className="form-group">
                <input name="otp" onChange={handleRegisterInputChange} tabIndex="2" className="form-control" placeholder="OTP" value={registerDetails.otp}/>
            </div>
            {
                requestType==="forget_password" ? (
                    <div className="form-group">
                        <input name="new_password" onChange={handleRegisterInputChange} tabIndex="2" className="form-control" placeholder="New Password" value={registerDetails.new_password}/>
                    </div>
                ) : ""
            }
            <div className="form-group">
                <div className="row">
                    <button type="button" className="btn btn-register form-control" onClick={verifyOTP}>{ requestType==="register" ? "Verify OTP" : "Update Password" }</button>
                </div>
            </div>
        </>
    )
}

export default Otp;