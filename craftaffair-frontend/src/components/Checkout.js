import React ,{ useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { Link, useNavigate } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import { getCartDetailsFromLocalStorage, removeCartDetailsFromLocalStorage } from "../Utils";
import axios from 'axios';

function Checkout(){
    const userState = useSelector(state => state.user);
    const cartState = useSelector(state => state.cart);
    const navigate = useNavigate();
    const [ addresses, userAddresses ] = useState([]);
    const [ cartDetails, setCartDetails ] = useState([]);
    const [ selectedAddress, setSelectedAddress ] = useState();

    useEffect(() => {
        setCartDetails(getCartDetailsFromLocalStorage());
    }, []);

    useEffect(()=>{
        axios.post(process.env.REACT_APP_BASE_URL + '/get_addresses',{
            user_id : userState.userId
        },{
            headers: {
                "Authorization" : `Bearer ${userState.authToken}`
            }
        }).then(function (response) {
            if(response.data.status===true){
                userAddresses(response.data.data);
            }else{
                alert(response.data.message);
            }
        }).catch(function (error) {
            console.log(error);
        });
    },[]);

    const placeOrder = () => {
        axios.post(process.env.REACT_APP_BASE_URL + '/place-order',{
            user_id : userState.userId,
            address_id : selectedAddress,
            cart_details : JSON.stringify(cartDetails)
        },{
            headers: {"Authorization" : `Bearer ${userState.authToken}` }
        }).then(function (response) {
            if(response.data.status===true){
                removeCartDetailsFromLocalStorage();
                alert(response.data.message);
                navigate(routeConstants.INDEX_PAGE);
            }else{
                alert(response.data.message);
            }
        }).catch(function (error) {
            console.log(error);
        });
    }

    return(
        <>
            <section className="breadcrumb-option">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-12">
                                <div className="breadcrumb__text">
                                    <h4>Check Out</h4>
                                    <div className="breadcrumb__links">
                                        <Link to={routeConstants.INDEX_PAGE}>Home</Link>
                                        <Link to={routeConstants.INDEX_PAGE}>Shop</Link>
                                        <span>Check Out</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
                <section className="checkout spad">
                    <div className="container">
                        <div className="checkout__form">
                            <form action="#">
                                <div className="row">
                                    <div className="col-lg-8 col-md-6">
                                        <h6 className="coupon__code"><span className="icon_tag_alt"></span> Have a coupon? <Link>Click
                                        here</Link> to enter your code</h6>
                                        <h6 className="checkout__title">Select Address</h6>
                                        {
                                            addresses && addresses.length>0 && addresses.map((address,i)=>(
                                                <>
                                                    <div className="row">
                                                        <div className="col-md">
                                                            <input type="radio" name="user_address" onClick={()=>setSelectedAddress(address.id)} value={address.id} className="form-control"/>
                                                        </div>
                                                        <div className="col-md">
                                                            <label>{ address.title }</label>
                                                        </div>
                                                        <div className="col-md">
                                                            <address>
                                                                address
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </>
                                            ))
                                        }
                                    </div>
                                    <div className="col-lg-4 col-md-6">
                                        <div className="checkout__order">
                                            <h4 className="order__title">Your order</h4>
                                            <div className="checkout__order__products">Product <span>Total</span></div>
                                            <ul className="checkout__total__products">
                                                {
                                                    cartDetails.items && cartDetails.items.length>0 && cartDetails.items.map((cartItem,i)=>(
                                                        cartItem.cartDetails.map((cartDetail,j)=>(
                                                            <li key={j}>{ cartItem.product_name } ({ cartDetail.variant_name }) <span>$ { cartDetail.total_price 
                                                            }</span></li>
                                                        ))
                                                    ))
                                                }
                                            </ul>
                                            <ul className="checkout__total__all">
                                                <li>Subtotal <span>${ cartState.sub_total }</span></li>
                                                <li>Total <span>${ cartState.total_price }</span></li>
                                            </ul>
                                            <div className="checkout__input__checkbox">
                                                <label Htmlfor=	"acc-or">
                                                    Create an account?
                                                    <input type="checkbox" id="acc-or" />
                                                    <span className="checkmark"></span>
                                                </label>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                            ut labore et dolore magna aliqua.</p>
                                            <div className="checkout__input__checkbox">
                                                <label Htmlfor=	"payment">
                                                    Check Payment
                                                    <input type="checkbox" id="payment" />
                                                    <span className="checkmark"></span>
                                                </label>
                                            </div>
                                            <div className="checkout__input__checkbox">
                                                <label Htmlfor=	"paypal">
                                                    Paypal
                                                    <input type="checkbox" id="paypal" />
                                                    <span className="checkmark"></span>
                                                </label>
                                            </div>
                                            <button type="button" className="site-btn" onClick={placeOrder}>PLACE ORDER</button>
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
export default Checkout;