import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { routeConstants } from '../routeConstants';
import { setCartItemInLocalStorage, getCartItemInLocalStorage } from "../Utils";
import axios from 'axios';

function ProductList(){
    const params = useParams();
    const [ products, setProducts] = useState([]);
    const [ variants, setVariants] = useState([]);
    const [ filters, setFilters] = useState([]);
    const [ cartItems, setCartItems] = useState([]);
    const [ searchStr, setSearchStr ] = useState("");

	useEffect(()=>{
		setCartItems(getCartItemInLocalStorage());
    },[])

	useEffect(()=>{
		axios.post(process.env.REACT_APP_BASE_URL + '/list-product-by-category-id',{
			category_id : params.categoryId
		}).then(function (response) {
			if(response.data.status===true){
				setProducts(response.data.data.products);
                setVariants(response.data.data.variants);
			}else{
				alert(response.data.message);
			}
		}).catch(function (error) {
			console.log(error);
		});
	},[params]);

    const handleInputChange = (e) => {
        setSearchStr(e.target.value);
    }

    const handleFilterChange = (e) => {
        let tempFilters = [ ...filters ];
        let filterExists = 0;
        let filterIndex = -1;

        for(let i=0;i<tempFilters.length;i++){
            if(tempFilters[i].variant_id===e.target.name){
                filterExists = 1;
                filterIndex = i;
                break;
            }
        }

        if(filterExists===0 && filterIndex===-1){
            tempFilters.push({
                variant_id : e.target.name,
                variant_value : e.target.value
            })
        }else if(filterExists===1 && filterIndex!==-1){
            tempFilters[filterIndex].variant_value = e.target.value;
        }
        setFilters(tempFilters);
    }

    const applyFilter = () => {
		axios.post(process.env.REACT_APP_BASE_URL + '/list-product-by-category-id',{
			category_id : params.categoryId,
            search_str : searchStr,
            filter_data : filters
		}).then(function (response) {
			if(response.data.status===true){
				setProducts(response.data.data.products);
                setVariants(response.data.data.variants);
			}else{
				alert(response.data.message);
			}
		}).catch(function (error) {
			console.log(error);
		});
    }

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

    return (
        <>
            <section className="shop spad">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-3 col-md-3 col-sm-3">
                            <div className="shop__sidebar">
                                <div className="shop__sidebar__search">
                                    <form action="#">
                                        <input name="search_str" onChange={handleInputChange} placeholder="Search..." value={searchStr}/>
                                        <button type="submit"><span className="fa fa-search"></span></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {
                            variants && variants.length>0 && variants.map((variant,i)=>(
                                <div className="col-lg-3 col-md-3 col-sm-3" key={i}>
                                    <select className="form-control" name={variant.variant_id} onChange={handleFilterChange}>
                                        <option value="">{ variant.variant_name }</option>
                                        {
                                            variant.possible_values && variant.possible_values.length>0 && variant.possible_values.map((possible_value)=>(
                                                <option value={ possible_value }>{ possible_value }</option>
                                            ))
                                        }
                                    </select>
                                </div>
                            ))
                        }
                        <div className="col-lg-3 col-md-3 col-sm-3">
                            <div className="shop__sidebar">
                                <div className="shop__sidebar__search">
                                    <button type="button" className="btn btn-primary" onClick={applyFilter}>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        {
                            products && products.length>0 && products.map((product,i)=>(
                                <div className="col-lg-4 col-md-6 col-sm-6" key={i}>
                                    <Link to={routeConstants.PRODUCT_DETAILS_PAGE + '/'+product.product_id} className="product__item">
                                        <img className="img-responsive" src={product.image_url} /> 
                                        <div className="product__item__text">
                                            <h6>{product.product_name}</h6>
                                            <div className="rating">
                                                <i className="fa fa-star-o"></i>
                                                <i className="fa fa-star-o"></i>
                                                <i className="fa fa-star-o"></i>
                                                <i className="fa fa-star-o"></i>
                                                <i className="fa fa-star-o"></i>
                                            </div>
                                            <h5>&#8377;{product.price}</h5>
                                        </div>
                                    </Link>
                                    <Link className="primary-btn" onClick={()=>addToCart(product.product_id,product.product_name,product.variant_id,product.price,product.variant_name,product.image_url)}>+ Add To Cart</Link>
                                </div>
                            ))
                        }
                    </div>
                </div>
            </section>
        </>
    )
}

export default ProductList;