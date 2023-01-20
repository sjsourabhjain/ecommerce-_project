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
    const [ categories, setCategories] = useState([]);

	useEffect(()=>{
		setCartItems(getCartItemInLocalStorage());
    },[])
    useEffect(()=>{
        axios.get(process.env.REACT_APP_BASE_URL + '/list-category-image')
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

            <section className="slider">
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
            </section>

            <section>
                <div id="demo" className="carousel slide" data-ride="carousel">
                    <ul className="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" className="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ul>
                    <div className="carousel-inner">
                        <div className="carousel-item active">
                            <img src="img/banner/banner-3.jpg" alt="Los Angeles" width="1100" height="500" />
                            <div className="carousel-caption">
                                <h3>Los Angeles</h3>
                                <p>We had such a great time in LA!</p>
                            </div>   
                        </div>
                        <div className="carousel-item">
                            <img src="img/banner/banner-1.jpg" alt="Chicago" width="1100" height="500" />
                            <div className="carousel-caption">
                                <h3>Chicago</h3>
                                <p>Thank you, Chicago!</p>
                            </div>   
                        </div>
                        <div className="carousel-item">
                            <img src="img/banner/banner-2.jpg" alt="New York" width="1100" height="500" />
                            <div className="carousel-caption">
                                <h3>New York</h3>
                                <p>We love the Big Apple!</p>
                            </div>   
                        </div>
                    </div>
                    <a className="carousel-control-prev" href="#demo" data-slide="prev">
                        <span className="carousel-control-prev-icon"></span>
                    </a>
                    <a className="carousel-control-next" href="#demo" data-slide="next">
                        <span className="carousel-control-next-icon"></span>
                    </a>
                </div>
            </section>

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
            <section className="category">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <h3 className="related-title">Trending</h3>
                            <h4 className="exploreProducts">Explore All </h4>
                            <hr/>
                        </div>
                    </div>
                    <div className="row">
                    {
                        categories && categories.length>0 && categories.map((category,i)=>(
                            <div className="col-lg-3 col-md-6 col-sm-6 categoryProduct">
                                <div className="product__item">
                                    <img className="product__item__pic set-bg" src={category.category_image} />
                                    <div className="product__item__text">
                                        <h6>{category.category_name}</h6> 
                                    </div>
                                </div>
                            </div>
                        ))
                    }
                    </div>
                </div>
            </section>
        </>
    )
}

export default Home;