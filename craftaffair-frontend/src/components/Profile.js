import React ,{ useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { Link } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import Address from './Address';
import axios from 'axios';

function Profile(){
    const userState = useSelector(state => state.user);
    const [ profile, setUserProfile ] = useState({});

    useEffect(()=>{
        axios.post(process.env.REACT_APP_BASE_URL + '/profile',{
            user_id : userState.userId
        },{
            headers: {
                "Authorization" : `Bearer ${userState.authToken}`
              }
        }).then(function (response) {
            if(response.data.status===true){
                console.log("USER_DETAILS:",response.data.data)
                setUserProfile({
                    "user_id" : response.data.data.id,
                    "full_name" : response.data.data.full_name,
                    "email" : response.data.data.email,
                    "mob_no" : response.data.data.mob_no
                });
            }else{
                alert(response.data.message);
            }
        }).catch(function (error) {
            console.log(error);
        });
    },[userState]);

    const updateProfile = () => {
        if(profile.user_id==="" || profile.full_name==="" || profile.email==="" || profile.mob_no===""){
            alert("Please fill all fields.");
        }else{
            axios.post(process.env.REACT_APP_BASE_URL + '/update-profile',profile,{
                headers: {
                    "Authorization" : `Bearer ${userState.authToken}`
                }
            }).then(function (response) {
                if(response.data.status===true){
                    alert("Profile has been updated");
                }else{
                    alert(response.data.message);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

    const handleProfileInputChange = (e) => {
        setUserProfile({
            ...profile,
            [e.target.name] : e.target.value
        })
    }
return (
		<>
		<section style={{bgcolor: "#eee"}}>
    	    <div className="container py-5">
        		<div className="row">
                    <div className="col">
            			<nav aria-label="breadcrumb" className="bg-light rounded-3 p-3 mb-4">
                            <ol className="breadcrumb mb-0">
            				    <li className="breadcrumb-item"><Link to={routeConstants.INDEX_PAGE}>Home</Link></li>
            				    <li className="breadcrumb-item"><a href="#">User</a></li>
            				    <li className="breadcrumb-item active" aria-current="page">User Profile</li>
                            </ol>
            			</nav>
        		    </div>
        		</div>
                <div className="row">
                    <div className="col-lg-4">
                        <div className="card mb-4">
                            <div className="card-body text-center">
                                <img src={"https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"} alt="avatar"
                                    className="rounded-circle img-fluid" style={{width: "150px"}} />
                                <h5 className="my-3"></h5>
                                <p className="text-muted mb-1">Full Stack Developer</p>
                                <p className="text-muted mb-4">Bay Area, San Francisco, CA</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-8">
                        <div className="card mb-4">
                            <div className="card-body">
                                <div className="row">
                                    <div className="col-sm-3">
                                        <p className="mb-0">Full Name</p>
                                    </div>
                                    <div className="col-sm-9">
                                        <p className="text-muted mb-0">{profile.full_name}</p>
                                    </div>
                                </div>
                                <hr />
                                <div className="row">
                                    <div className="col-sm-3">
                                        <p className="mb-0">Email</p>
                                    </div>
                                    <div className="col-sm-9">
                                        <p className="text-muted mb-0">{profile.email}</p>
                                    </div>
                                </div>
                                <hr />
                                <div className="row">
                                    <div className="col-sm-3">
                                        <p className="mb-0">Mobile</p>
                                    </div>
                                    <div className="col-sm-9">
                                        <p className="text-muted mb-0">{profile.mob_no}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
        <div className="container">
            <div className="col-md-4"></div>
            <div className="col-md-8">
            <ul className="nav nav-pills">
                <li className="nav-item">
                    <a className="nav-link active" data-toggle="pill" href="#home">Edit Profile</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" data-toggle="pill" href="#menu1">Orders</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" data-toggle="pill" href="#menu2">Manage Address</a>
                </li>
            </ul>
            <div className="tab-content">
              <div className="tab-pane container active" id="home">
                    <div className="container mt-2">
                        <form >
                            <div className="form-group">
                                <input name="full_name" className="form-control" placeholder="Full Name" onChange={handleProfileInputChange} value={profile.full_name}/>
                            </div>
                            <div className="form-group">
                                <input name="mobile_no" className="form-control" placeholder="Mobile Number" onChange={handleProfileInputChange} value={profile.mob_no}/>
                            </div>
                            <div className="form-group">
                                <input name="email" className="form-control" placeholder="Email Address" onChange={handleProfileInputChange} value={profile.email} />
                            </div>
                            <div className="form-group">
                                <button className="form-control btn btn-primary" type="button" onClick={updateProfile}>Update</button>
                            </div>
                        </form>
                    </div>
              </div>
              <div className="tab-pane container fade" id="menu1">
                    <div className="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    //cartItems.map((cartItem,i)=>(
                                       // cartItem.cartDetails.length > 0 && cartItem.cartDetails.map((cartDetail,j)=>(
                                            <tr>
                                                
                                            </tr>
                                        //))
                                    //))
                                }
                            </tbody>
                        </table>
                    </div>
              </div>
              <div className="tab-pane container fade" id="menu2"><Address/></div>
            </div>
            </div>
        </div>
		</>
	);
}
export default Profile;