import React, { useState } from 'react';
import { connect } from 'react-redux';
function Login(props){
    const [userDetails,setUserDetails] = useState({  username: 'admin', email: 'admin@gmail.com', age: 22, password:'1234' });
    const [isLoggedin,setLoginStatus] = useState(0);
    const handleInputChange = (e) =>{
        setUserDetails({
            ...userDetails,
            [e.target.name] : e.target.value
        })
        setLoginStatus(0);
    }
    const doLogin = () =>{
        if(userDetails.username==="admin" && userDetails.password==="1234"){
            setLoginStatus(1);
        }
    }
    return(
        <div>
            <input type="text" name="username" onChange={handleInputChange} value={userDetails.username}/><br/><br/>
            <input type="text" name="email" onChange={handleInputChange} value={userDetails.email}/><br/><br/>
            <input type="text" name="age" onChange={handleInputChange} value={userDetails.age}/><br/><br/>
            <input type="text" name="password" onChange={handleInputChange} value={userDetails.password}/><br/><br/>
            <button disabled={isLoggedin} onClick={doLogin}>Login</button><br/><br/>
            <p>User Details:</p>
            <p>Username: {userDetails.username}</p>
            <p>Email:{userDetails.email}</p>
            <p>Age:{userDetails.age}</p>
            <p>Password:{userDetails.password}</p>
        </div>
    )
}
const mapStateToProps = (state)=>{
    return {
        //numOfCakes: state.numOfCakes
    }
}

const mapDispatchToProps = (dispatch)=>{
    return{
        //buyCake: () => dispatch(buyCake())
    }
}

export default connect(mapStateToProps,mapDispatchToProps)(Login);