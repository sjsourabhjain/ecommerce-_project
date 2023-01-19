import React, { useState } from 'react';
import { useNavigate } from "react-router-dom";
import { useSelector, useDispatch } from 'react-redux';
import { routeConstants } from '../routeConstants';
import { doLogin } from '../actions';

function Login(){
    const [userDetails,setUserDetails] = useState({  username: 'admin', email: 'admin@gmail.com', age: 22, password:'1234',isLoggedIn:1 });
    const [isLoggedin,setLoginStatus] = useState(0);
    const userState = useSelector(state => state.user);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const handleInputChange = (e) =>{
        setUserDetails({
            ...userDetails,
            [e.target.name] : e.target.value
        })
        setLoginStatus(0);
    }
    const login = () =>{
        if(userDetails.username==="admin" && userDetails.password==="1234"){
            dispatch(doLogin(userDetails));
            navigate(routeConstants.PROFILE);
        }
    }
    return(
        <div>
            <input type="text" name="username" onChange={handleInputChange} value={userDetails.username}/><br/><br/>
            <input type="text" name="email" onChange={handleInputChange} value={userDetails.email}/><br/><br/>
            <input type="text" name="age" onChange={handleInputChange} value={userDetails.age}/><br/><br/>
            <input type="text" name="password" onChange={handleInputChange} value={userDetails.password}/><br/><br/>
            <button disabled={isLoggedin} onClick={login}>Login</button><br/><br/>
            <p>User Details:</p>
            <p>Username: {userDetails.username}</p>
            <p>Email:{userDetails.email}</p>
            <p>Age:{userDetails.age}</p>
            <p>Password:{userDetails.password}</p>
            {userState.isLoggedIn}
        </div>
    )
}

export default Login;