import React,{ useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useNavigate } from "react-router-dom";
import axios from 'axios';
import { routeConstants } from '../routeConstants';
import { doLogout } from '../actions';
import { getCartDetailsFromLocalStorage } from "../Utils";
import search from '../img/icon/search.png';
import cart from '../img/icon/cart.png';
import logo from '../img/logo.png';

function Header(){
    const userState = useSelector(state => state.user);
    const cartState = useSelector(state => state.cart);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [ categories, setCategories ] = useState([]);
    const [ cartDetails, setCartDetails] = useState([]);
    const [ settings, setSettings] = useState({});

    const logout = () => {
        dispatch(doLogout({
            isLoggedIn : 0,
            mobile_no : "",
            email : "",
            authToken : "",
            userId : 0
        }));
        alert("You are logged out.");
        navigate(routeConstants.LOGIN_REGISTRATION_PAGE);
    }

    useEffect(() => {
        setCartDetails(getCartDetailsFromLocalStorage());
    }, [userState]);
    
    useEffect(()=>{
        axios.get(process.env.REACT_APP_BASE_URL + '/list-category')
          .then(function (response) {
            if(response.data.status===true){
                setCategories(response.data.data);
            }else{
                alert(response.data.message);
            }
          })
          .catch(function (error) {
            console.log(error);
          });
    },[])
    
    useEffect(()=>{
        axios.get(process.env.REACT_APP_BASE_URL + '/list-settings')
          .then(function (response) {
            if(response.data.status===true){
                setSettings(response.data.data.settings);
            }else{
                alert(response.data.message);
            }
          })
          .catch(function (error) {
            console.log(error);
          });
    },[])
    return(
        <>
            <div className="offcanvas-menu-overlay"></div>
                <div className="offcanvas-menu-wrapper">
                    <div className="offcanvas__option">
                        <div className="offcanvas__links">
                            {
                                userState!=null && userState.isLoggedIn ? "" :  (<Link to={routeConstants.LOGIN_REGISTRATION_PAGE}>Sign in</Link>)
                            }
                        </div>
                    </div>
                    <div className="offcanvas__nav__option">
                        <a href="#" className="search-switch"><img src={search} alt=""/></a>
                        <Link to={routeConstants.CART}><img src={cart} alt=""/> <span>0</span></Link>
                        <div className="price">${  cartDetails.total }</div>
                    </div>
                    <div id="mobile-menu-wrap"></div>
                    <div className="offcanvas__text">
                        <p>{ settings.promotion_line }</p>
                    </div>
                </div>
            <header className="header">
                <div className="header__top">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-6 col-md-7">
                                <div className="header__top__left">
                                    <p>{ settings.promotion_line }</p>
                                </div>
                            </div>
                            <div className="col-lg-6 col-md-5">
                                <div className="header__top__right">

                                    <div className="header__top__links">
                                    {
                                        userState!=null && userState.isLoggedIn ? (
                                        <div className="dropdown">
                                            <button className="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                            Account
                                            <span className="caret"></span></button>
                                            <ul className="dropdown-menu">
                                              <li><Link to={routeConstants.PROFILE}>Profile</Link></li>
                                              <li><Link onClick={logout}>Logout</Link></li>
                                            </ul>
                                        </div>) :  (<Link to={routeConstants.LOGIN_REGISTRATION_PAGE}><i className="fa fa-user"></i></Link>)
                                    }
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-3 col-md-3">
                            <div className="header__logo">
                                <Link to={routeConstants.INDEX_PAGE}><img src={logo} alt=""/></Link>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6">
                            <nav className="header__menu mobile-menu">
                                <ul>
                                    {
                                        categories && categories.length>0 && categories.map((category,i)=>(
                                            <li key={i}>
                                                {
                                                    category.sub_categories && category.sub_categories.length>0 ? (
                                                    <>
                                                        <Link to={routeConstants.PRODUCT_LISTING + '/' + category.category_id}>{ category.category_name }</Link>
                                                        <ul className="dropdown">
                                                            {
                                                                category.sub_categories && category.sub_categories.length>0 && category.sub_categories.map((sub_category,j)=>(
                                                                    <li key={j}><Link to={routeConstants.PRODUCT_LISTING + '/' + sub_category.category_id}>{ sub_category.category_name }</Link></li>
                                                                ))
                                                            }
                                                        </ul>
                                                    </>
                                                    ) : (<Link to={routeConstants.PRODUCT_LISTING + '/' + category.category_id}>{ category.category_name }</Link>)
                                                }
                                                </li>
                                        ))
                                    }
                                </ul>
                            </nav>
                        </div>
                        <div className="col-lg-3 col-md-3">
                            <div className="header__nav__option">
                                <a href="#" className="search-switch"><img src={search} alt=""/></a>
                                <Link to="/cart"><img src={cart} alt=""/> <span>0</span></Link>
                                <div className="price">${ cartState.total_price }</div>
                            </div>
                        </div>
                    </div>
                    <div className="canvas__open"><i className="fa fa-bars"></i></div>
                </div>
            </header>
        </>
    );
}
export default Header;