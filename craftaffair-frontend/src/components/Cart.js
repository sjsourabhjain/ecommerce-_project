import React, { useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { Link } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import { updateCartPrice } from '../actions';
import axios from 'axios';

import { getCartDetailsFromLocalStorage } from "../Utils";

function Cart(){
    const dispatch = useDispatch();
    const userState = useSelector(state => state.user);
    const cartItems = useSelector(state => state.cart);

    useEffect(() => {
        storeCartDetailsInDB();
    }, []);

    const storeCartDetailsInDB = () => {
        const cartProductDetails = JSON.stringify(getCartDetailsFromLocalStorage());
        if(userState.isLoggedIn && cartProductDetails!=''){
            axios.post(process.env.REACT_APP_BASE_URL + '/cart-details',{
                user_id : userState.userId,
                cart_details : cartProductDetails
            }).then(function (response) {
                if(response.data.status===true){
                    console.log("CART_DATA: ",response.data.message);
                }else{
                    alert(response.data.message);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

    const removeItem = (prodVariantId) => {
        let tmpCartItems = [...cartItems.items];

        tmpCartItems = tmpCartItems.map((tempCartItem) => {
            return {...tempCartItem, cartDetails: tempCartItem.cartDetails.filter((cartDetail) => cartDetail.variant_id === prodVariantId ? "" : cartDetail )}
        })

        let sub_total = 0;
	    let tax_amount = 0;
	    let total = 0;

	    for(let i=0;i<tmpCartItems.length;i++){
	        let items = tmpCartItems[i].cartDetails;
	        for(let j=0;j<items.length;j++){
	            sub_total = parseInt(sub_total) + parseInt(items[j].variant_price * items[j].qty);
	        }
	    }

	    tax_amount = parseFloat(0.18*sub_total).toFixed(2);
	    total = parseFloat(sub_total) + parseFloat(tax_amount);

	    const cartData = {
		    "sub_total" : sub_total,
		    "tax_amount" : tax_amount,
		    "total_price" : total,
	        "items" : tmpCartItems
	    }

	    dispatch(updateCartPrice(cartData));
        //storeCartDetailsInDB();
    }

    return(
        <>
            <section className="breadcrumb-option">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <div className="breadcrumb__text">
                                <h4>Shopping Cart</h4>
                                <div className="breadcrumb__links">
                                    <a href="./index.html">Home</a>
                                    <a href="./shop.html">Shop</a>
                                    <span>Shopping Cart</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section className="shopping-cart spad">
                <div className="container">
                    { cartItems.items && cartItems.items.length>0 ? (
                        <div className="row">
                        <div className="col-lg-8">
                            <div className="shopping__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {
                                            cartItems.items.map((cartItem,i)=>(
                                                cartItem.cartDetails.length > 0 && cartItem.cartDetails.map((cartDetail,j)=>(
                                                    <tr key={j}>
                                                        <td className="product__cart__item">
                                                            <div className="product__cart__item__pic">
                                                                <img src="img/shopping-cart/cart-1.jpg" alt=""/>
                                                            </div>
                                                            <div className="product__cart__item__text">
                                                                <h6>{ cartItem.product_name } ({ cartDetail.variant_name })</h6>
                                                                <h5>${ cartDetail.variant_price }</h5>
                                                            </div>
                                                        </td>
                                                        <td className="quantity__item">
                                                            <div className="quantity">
                                                                <div className="pro-qty-2">
                                                                    <input value={cartDetail.qty}/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td className="cart__price">$ { cartDetail.total_price }</td>
                                                        <td className="cart__close"><i onClick={()=>{removeItem(cartDetail.variant_id) }} className="fa fa-close"></i></td>
                                                    </tr>
                                                ))
                                            ))
                                        }
                                    </tbody>
                                </table>
                            </div>
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="continue__btn">
                                        <Link to={routeConstants.INDEX_PAGE}>Continue Shopping</Link>
                                    </div>
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="continue__btn update__btn">
                                        <Link><i className="fa fa-spinner"></i> Update cart</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4">
                            <div className="cart__discount">
                                <h6>Discount codes</h6>
                                <form action="#">
                                    <input type="text" placeholder="Coupon code" />
                                    <button type="submit">Apply</button>
                                </form>
                            </div>
                            <div className="cart__total">
                                <h6>Cart total</h6>
                                <ul>
                                    <li>Subtotal <span>$ { cartItems.sub_total }</span></li>
                                    <li>Total <span>$ { cartItems.total_price }</span></li>
                                </ul>
                                <Link to={routeConstants.CHECKOUT} className="primary-btn">Proceed to checkout</Link>
                            </div>
                        </div>
                    </div>

                    ) : (<></>)

                    }
                </div>
            </section>
        </>
    );
}
export default Cart;