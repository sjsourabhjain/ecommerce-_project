import React ,{ useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import { setCartItemInLocalStorage, getCartItemInLocalStorage } from "../Utils";
import Header from './Header';
import Footer from './Footer';
import axios from 'axios';

function Home(){
    const [ sliders, setSliders ] = useState([]);
    const [ products, setProducts ] = useState([]);
    const [ cartItems, setCartItems] = useState([]);

	useEffect(()=>{
		setCartItems(getCartItemInLocalStorage());
    },[])

    useEffect(()=>{
        axios.get(process.env.REACT_APP_BASE_URL + '/list-slider')
          .then(function (response) {
            if(response.data.status===true){
                setSliders(response.data.data.sliders);
            }else{
                alert(response.data.message);
            }
          })
          .catch(function (error) {
            console.log(error);
          });
    },[])

    useEffect(()=>{
        axios.get(process.env.REACT_APP_BASE_URL + '/list-product')
          .then(function (response) {
            if(response.data.status===true){
                setProducts(response.data.data.products);
            }else{
                alert(response.data.message);
            }
          })
          .catch(function (error) {
            console.log(error);
          });
    },[])

    const addToCart = (productId,productName,prodVariantId,prodVariantPrice,variationName,imageUrl) => {

        let tmpCartItems = [...cartItems];

        let itemExists = 0;
        let productExists = 0;
        let productIndex = -1;
        
		for(let i=0;i<tmpCartItems.length;i++){
            if(tmpCartItems[i].product_id===productId){
                productExists = 1;
                productIndex = i;
            }
            let items = tmpCartItems[i].cartDetails;
            for(let j=0;j<items.length;j++){
                if(items[j].variant_id===prodVariantId){
                    itemExists = 1;
                    break;
                }
            }
        }

        if(itemExists===0 && productExists===0){
            tmpCartItems.push({
                product_name : productName,
                product_id : productId,
                image_url : imageUrl,
                cartDetails : [{
                    variant_name : variationName,
                    variant_id : prodVariantId,
                    variant_price : prodVariantPrice,
                    qty : 1,
                    total_price : prodVariantPrice
                }]
            })
        }else if(itemExists===0 && productExists===1 && productIndex!==-1){
            tmpCartItems[productIndex].cartDetails.push({
                variant_name : variationName,
                variant_id : prodVariantId,
                variant_price : prodVariantPrice,
                qty : 1,
                total_price : prodVariantPrice
            })
        }

        setCartItems(tmpCartItems);
        setCartItemInLocalStorage(tmpCartItems);
    }

    return(
        <>
            <div id="myCarousel" className="carousel slide" data-ride="carousel">
                <ul className="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" className="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                </ul>
                <div className="carousel-inner">
                {
                    sliders && sliders.length>0 && sliders.map((slider,i)=>(
                        <div key={i} className={"carousel-item " + (i==0 ? 'active' : '')}>
                            <img src={slider} alt="Chicago" className="sliderImage"/>
                        </div>
                    ))
                }
                </div>
                <a className="left carousel-control" href="#myCarousel" data-slide="prev">
                  <span className="glyphicon glyphicon-chevron-left"></span>
                  <span className="sr-only">Previous</span>
                </a>
                <a className="right carousel-control" href="#myCarousel" data-slide="next">
                  <span className="glyphicon glyphicon-chevron-right"></span>
                  <span className="sr-only">Next</span>
                </a>
            </div>
                <section className="related spad">
        <div className="container">
            <div className="row">
                <div className="col-lg-12">
                    <h3 className="related-title">Biggest Deals</h3>
                    <h4 className="exploreProducts">Explore All </h4>
                    <hr/>
                </div>
            </div>
            <div className="row">
                <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div className="product__item">
                        <img className="product__item__pic set-bg" src="img/product/product-1.jpg" />
                        <div className="product__item__text">
                            <h6>Piqué Biker Jacket</h6> 
                            <h5>$67.24</h5>
                        </div>
                    </div>
                </div>
                <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div className="product__item">
                        <img className="product__item__pic set-bg" src="img/product/product-1.jpg" />
                        <div className="product__item__text">
                            <h6>Piqué Biker Jacket</h6> 
                            <h5>$67.24</h5>
                        </div>
                    </div>
                </div>
                <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div className="product__item">
                        <img className="product__item__pic set-bg" src="img/product/product-1.jpg" />
                        <div className="product__item__text">
                            <h6>Piqué Biker Jacket</h6> 
                            <h5>$67.24</h5>
                        </div>
                    </div>
                </div>
                <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div className="product__item">
                        <img className="product__item__pic set-bg" src="img/product/product-1.jpg" />
                        <div className="product__item__text">
                            <h6>Piqué Biker Jacket</h6> 
                            <h5>$67.24</h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
        </>
    )
}

export default Home;