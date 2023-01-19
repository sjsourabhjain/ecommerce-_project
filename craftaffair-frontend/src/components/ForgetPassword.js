import React, { useState } from 'react';
import axios from 'axios';
import Otp from './Otp';

const ForgetPassword = () => {
    const [loginDetails, setLoginDetails] = useState({ mobile_no : "" });
    const [showOTPSection, setOtpField] = useState(false);
    const handleLoginInputChange = (e) => {
        setLoginDetails({
            ...loginDetails,
            [e.target.name] : e.target.value
        })
    }

    const sendOTP = () => {
        if(loginDetails.mobile_no===""){
            alert("Please fill all fields.");
        }else{
            axios.post(process.env.REACT_APP_BASE_URL + '/forget-password', {
                mob_no: loginDetails.mobile_no
              })
              .then(function (response) {
                if(response.data.status===true){
                    setOtpField(true);
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
        <div className="card signup_v4 mb-30">
        <div className="card-body">
            <div className="tab-content" id="myTabContent">
                 <div className="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                    {
                        showOTPSection ? ( 
                            <Otp mobile_no={loginDetails.mobile_no} useType="forget_password"/>
                        ) : (
                            <>
                                <div className="form-group">
                                    <input name="mobile_no" onChange={handleLoginInputChange} tabIndex="1" className="form-control" placeholder="Mobile No." value={loginDetails.mobile_no}/>
                                </div>
                                <div className="form-group">
                                    <button type="button" disabled={!loginDetails.mobile_no} onClick={sendOTP} className="form-control btn btn-primary">Send OTP</button>
                                </div>
                            </>
                        )
                    }
                </div>
            </div>
        </div>
    </div>
    )
}

export default ForgetPassword;