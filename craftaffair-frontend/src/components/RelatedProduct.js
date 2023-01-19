import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import axios from 'axios';

const RelatedProduct = (props) => {
	const [ relatedProducts, setRelatedProducts] = useState([]);
	useEffect(()=>{
		axios.post(process.env.REACT_APP_BASE_URL + '/get-related-products',{
			product_id : props.productId
		}).then(function (response) {
			if(response.data.status===true){
				setRelatedProducts(response.data.data);
			}else{
				alert(response.data.message);
			}
		  }).catch(function (error) {
			console.log(error);
		  });
	},[props.productId]);

    return (
        <section className="related spad">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <h3 className="related-title">Related Product</h3>
                    </div>
                </div>
                <div className="row">
                    {
                        relatedProducts && relatedProducts.length>0 && relatedProducts.map((relatedProduct,i)=>(
                            <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6" key={i}>
                            <div className="product__item">
                                <Link to={routeConstants.PRODUCT_DETAILS_PAGE + '/'+relatedProduct.product_id}><img className="product__item__pic set-bg" src={relatedProduct.image_url} alt="no_image"/></Link>
                                <span className="label">New</span>
                                <div className="product__item__text">
                                    <h6>{ relatedProduct.product_name }</h6>
                                    <Link className="add-cart">+ Add To Cart</Link>
                                    <div className="rating">
                                        <i className="fa fa-star-o"></i>
                                        <i className="fa fa-star-o"></i>
                                        <i className="fa fa-star-o"></i>
                                        <i className="fa fa-star-o"></i>
                                        <i className="fa fa-star-o"></i>
                                    </div>
                                    <h5>${ relatedProduct.price }</h5>
                                </div>
                            </div>
                        </div>
                        ))
                    }
                </div>
            </div>
        </section>
    )
}
export default RelatedProduct;