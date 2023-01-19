import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { routeConstants } from '../routeConstants';
import { updateCartPrice } from '../actions';
import RelatedProduct from './RelatedProduct';
import axios from 'axios';

function ProductDetails(){
	const params = useParams();
	const dispatch = useDispatch();
	const cartState = useSelector(state => state.cart);
	const [productDetails, setProductDetails] = useState({});
	const [galleryImages, setgalleryImages] = useState([]);
	const [currentProductVariant, setCurrentProductVariant] = useState({});

	useEffect(()=>{
		axios.post(process.env.REACT_APP_BASE_URL + '/get-product-by-id',{
			product_id : params.productId
		}).then(function (response) {
			if(response.data.status===true){
				setProductDetails(response.data.data.product_details);
				setCurrentProductVariant({
					productId : response.data.data.product_details.product_id,
					productName : response.data.data.product_details.product_name,
					prodVariantId : response.data.data.product_details.product_primary_variant_details.id,
					prodVariantPrice : response.data.data.product_details.product_primary_variant_details.price,
					variationDetails: response.data.data.product_details.product_primary_variant_details.variation_details,
					description : response.data.data.product_details.product_primary_variant_details.description
				});
				setgalleryImages(response.data.data.product_details.product_primary_variant_details.images);
			}else{
				alert(response.data.message);
			}
		  }).catch(function (error) {
			console.log(error);
		  });
	},[params]);

	const updateCurrentProductVariant = (prodVariantId,prodVariantPrice,productId,productName,variationDetails,variantImages,description) => {
		setgalleryImages(variantImages);

		setCurrentProductVariant({
			productId : productId,
			productName : productName,
			prodVariantId : prodVariantId,
			prodVariantPrice : prodVariantPrice,
			variationDetails: variationDetails,
			description: description
		});
	}

	const addToCart = () => {
        let tmpCartItems = [...cartState.items];
		
        let variation_name = "";
        
        for(let i=0;i<currentProductVariant.variationDetails.length;i++){
            variation_name += (i===0 ? "" : " - ") + currentProductVariant.variationDetails[i].variant_value;
        }

        let itemExists = 0;
        let productExists = 0;
        let productIndex = -1;
        
		for(let i=0;i<tmpCartItems.length;i++){
            if(tmpCartItems[i].product_id===currentProductVariant.productId){
                productExists = 1;
                productIndex = i;
            }
            let items = tmpCartItems[i].cartDetails;
            for(let j=0;j<items.length;j++){
                if(items[j].variant_id===currentProductVariant.prodVariantId){
                    itemExists = 1;
                    break;
                }
            }
        }

        if(itemExists===0 && productExists===0){
            tmpCartItems.push({
                product_name : currentProductVariant.productName,
                product_id : currentProductVariant.productId,
                cartDetails : [{
                    variant_name : variation_name,
                    variant_id : currentProductVariant.prodVariantId,
                    variant_price : currentProductVariant.prodVariantPrice,
                    qty : 1,
                    total_price : currentProductVariant.prodVariantPrice
                }]
            })
        }else if(itemExists===0 && productExists===1 && productIndex!==-1){
            tmpCartItems[productIndex].cartDetails.push({
                variant_name : variation_name,
                variant_id : currentProductVariant.prodVariantId,
                variant_price : currentProductVariant.prodVariantPrice,
                qty : 1,
                total_price : currentProductVariant.prodVariantPrice
            })
        }
	    
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

        //setCartItems(tmpCartItems);
        //setCartItemInLocalStorage(tmpCartItems);
	}

	return (
		<>
			<section className="shop-details">
		        <div className="product__details__pic">
		            <div className="container">
		                <div className="row">
		                    <div className="col-md-2">
		                        <ul className="nav nav-tabs" role="tablist">
									{
										galleryImages && galleryImages.length>0 && galleryImages.map((galleryImage,i)=>(
											<li className="nav-item" key={i}>
												<a className={i===0 ? "nav-link active" : "nav-link"} data-toggle="tab" href={"#tabs-"+(i+1)} role="tab">
													<img className="product__thumb__pic set-bg" src={galleryImage.imageUrl} alt="no_image" />
												</a>
											</li>
										))
									}
		                        </ul>
		                    </div>
		                    <div className="col-md-4">
		                        <div className="tab-content">
								{
									galleryImages && galleryImages.length>0 && galleryImages.map((galleryImage,i)=>(
										<div key={i} className={ i===0 ? "tab-pane active" : "tab-pane" } id={"tabs-"+(i+1)} role="tabpanel">
											<div className="product__details__pic__item">
												<img src={galleryImage.imageUrl} alt="no_image"/>
											</div>
										</div>
									))
								}
		                        </div>
		                    </div>
		                    <div className="col-md-6">
		                    	<div className="product__details__text">
		                            <h4>{ productDetails.product_name }</h4>
		                            <div className="rating">
		                                <i className="fa fa-star"></i>
		                                <i className="fa fa-star"></i>
		                                <i className="fa fa-star"></i>
		                                <i className="fa fa-star"></i>
		                                <i className="fa fa-star-o"></i>
		                                <span> - 5 Reviews</span>
		                            </div>
		                            <h3>&#8377;{currentProductVariant.prodVariantPrice}</h3>
		                            <p dangerouslySetInnerHTML={{ __html : currentProductVariant.description }}></p>
		                            <div className="product__details__option">
		                                <div className="product__details__option__size">
		                                    <span>Variants:</span>
											{
												productDetails.product_variants && productDetails.product_variants.length>0 && productDetails.product_variants.map((prod_variant,i)=>(
													<label key={i} htmlFor={prod_variant.id} onClick={()=>updateCurrentProductVariant(prod_variant.id,prod_variant.price,productDetails.product_id,productDetails.product_name,prod_variant.variation_details,prod_variant.variant_images,prod_variant.description)} className="active">{
														prod_variant.variation_details && prod_variant.variation_details.length>0 && prod_variant.variation_details.map((variation,k)=>(
															//(k==0 ? "" : " - ")  + variation.variant_name + `(${variation.variant_value})`
															(k===0 ? "" : " - ")  + `${variation.variant_value}`
														))
													}
														<input type="radio" id={prod_variant.id}/>
													</label>
												))
											}
		                                </div>
		                            </div>
		                            <div className="product__details__cart__option">
		                                <div className="quantity">
		                                    <div className="pro-qty">
		                                    <span className="fa fa-angle-up dec qtybtn"></span>
		                                    <input type="number"/>
		                                    <span className="fa fa-angle-down inc qtybtn"></span></div>
		                                </div>
		                                <Link onClick={addToCart} className="primary-btn">add to cart</Link>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
			</section>
			<RelatedProduct productId={params.productId}/>
		</>
	);
}
export default ProductDetails;