import React, { useState } from 'react';
import { useNavigate, Link } from "react-router-dom";
import { useDispatch } from 'react-redux';
import axios from 'axios';
import { routeConstants } from '../routeConstants';
import { doLogin } from '../actions';
import "../login_register.css";
import Otp from './Otp';

function Register(){
    const navigate = useNavigate();
    const dispatch = useDispatch();

    const [registerDetails, setRegisterDetails] = useState({ mobile_no : "", otp : "", email : "", password : "", confirm_password : "" });
    const [loginDetails, setLoginDetails] = useState({ mobile_no : "", password : "" });
    const [showOTPSection,setOtpField] = useState(false);

    const handleRegisterInputChange = (e) => {
        setRegisterDetails({
            ...registerDetails,
            [e.target.name] : e.target.value
        })
    }

    const handleLoginInputChange = (e) => {
        setLoginDetails({
            ...loginDetails,
            [e.target.name] : e.target.value
        })
    }

    const logIn = () => {
        if(loginDetails.mobile_no==="" || loginDetails.password===""){
            alert("Please fill all fields");
        }else{
            axios.post(process.env.REACT_APP_BASE_URL + '/login', {
                mob_no: loginDetails.mobile_no,
                password: loginDetails.password,
              })
              .then(function (response) {
                if(response.data.status===true){
                    alert("Login successful");
                    dispatch(doLogin({
                        isLoggedIn : 1,
                        userId : response.data.data.id,
                        mobile_no : loginDetails.mobile_no,
                        email : response.data.data.email,
                        authToken : response.data.data.token
                    }));
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

    const register = () => {
        if(registerDetails.mobile_no==="" || registerDetails.password==="" || registerDetails.confirm_password===""){
            alert("Please fill all fields.");
        }else if(registerDetails.password!==registerDetails.confirm_password){
            alert("Password and Confirm Password do not match");
        }else{
            
            axios.post(process.env.REACT_APP_BASE_URL + '/register', {
                mob_no: registerDetails.mobile_no,
                email: registerDetails.email,
                password: registerDetails.password,
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

    return(
        <>
            <div className="card signup_v4 mb-30">
                <div className="card-body">
                    <ul className="nav nav-tabs" id="myTab" role="tablist">
                        <li className="nav-item" role="presentation">
                            <a className="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                        </li>
                        <li className="nav-item" role="presentation">
                            <a className="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                        </li>
                    </ul>
                    <div className="tab-content" id="myTabContent">
                            <div className="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <div className="form-group">
                                <input name="mobile_no" onChange={handleLoginInputChange} tabIndex="1" className="form-control" placeholder="Mobile No." value={loginDetails.mobile_no}/>
                            </div>
                            <div className="form-group">
                                <input type="password" onChange={handleLoginInputChange} name="password" tabIndex="2" className="form-control" placeholder="Password" value={loginDetails.password}/>
                            </div>
                            <div className="form-group text-center">
                                <input type="checkbox" tabIndex="3" className="" name="remember"/>
                                <label htmlFor="remember"> Remember Me</label>
                            </div>
                            <div className="form-group">
                                <button type="button" disabled={!loginDetails.mobile_no || !loginDetails.password} onClick={logIn} className="form-control btn btn-primary">Log In</button>
                            </div>
                            <div className="form-group">
                                <div className="row">
                                    <div className="col-lg-12">
                                        <div className="text-center">
                                            <Link to={routeConstants.FORGET_PASSWORD} tabIndex="5" className="forgot-password">Forgot Password?</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                {
                                    showOTPSection ? (
                                        <div className="form-group">
                                            <div className="row">
                                                <div className="col-sm-6 col-sm-offset-3">
                                                    <Otp mobile_no={registerDetails.mobile_no} useType="register"/>
                                                </div>
                                            </div>
                                        </div>
                                    ) : (
                                <>
                                    <div className="form-group">
                                        <input name="mobile_no" onChange={handleRegisterInputChange} tabIndex="1" className="form-control" placeholder="Mobile Number" value={registerDetails.mobile_no}/>
                                    </div>
                                    <div className="form-group">
                                        <input name="email" onChange={handleRegisterInputChange} tabIndex="1" className="form-control" placeholder="Email Address" value={registerDetails.email}/>
                                    </div>
                                    <div className="form-group">
                                        <input type="password" onChange={handleRegisterInputChange} name="password" tabIndex="2" className="form-control" placeholder="Password" defaultValue={registerDetails.password}/>
                                    </div>
                                    <div className="form-group">
                                        <input type="password" onChange={handleRegisterInputChange} name="confirm_password" tabIndex="2" className="form-control" placeholder="Confirm Password" defaultValue={registerDetails.confirm_password}/>
                                    </div>
                                    <div className="form-group">
                                        <div className="row">
                                            <div className="col-sm-6 col-sm-offset-3">
                                                <button disabled={!registerDetails.mobile_no || !registerDetails.password || !registerDetails.confirm_password} type="button" onClick={register} className="btn btn-primary form-control">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </>
                                    )
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Register;