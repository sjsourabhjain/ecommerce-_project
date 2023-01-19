import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import './App.css';
import Home from './components/Home';
import Register from './components/Register';
import ForgetPassword from './components/ForgetPassword';
import ProductList from './components/ProductList';
import ProductDetails from './components/ProductDetails';
import Profile from './components/Profile';
import Cart from './components/Cart';
import NoPage from './components/NoPage';
import Checkout from './components/Checkout';
import Address from './components/Address';
import Layout from './components/Layout';
import { routeConstants } from './routeConstants';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
            <Route path={routeConstants.INDEX_PAGE} element={<Layout component={<Home/>}/>}/>
            <Route path={routeConstants.PRODUCT_DETAILS_PAGE+'/:productId'} element={<Layout component={<ProductDetails/>}/>}/>
            <Route path={routeConstants.PRODUCT_LISTING+'/:categoryId'} element={<Layout component={<ProductList/>}/>}/>
            <Route path={routeConstants.LOGIN_REGISTRATION_PAGE} element={<Layout component={<Register/>}/>}/>
            <Route path={routeConstants.FORGET_PASSWORD} element={<Layout component={<ForgetPassword/>}/>}/>
            <Route path={routeConstants.PROFILE} element={<Layout component={<Profile/>}/>}/>
            <Route path={routeConstants.CART} element={<Layout component={<Cart/>}/>}/>
            <Route path={routeConstants.CHECKOUT} element={<Layout component={<Checkout/>}/>}/>
            <Route path={routeConstants.ADDRESS} element={<Layout component={<Address/>}/>}/>
            <Route path={routeConstants.WILDCARD} element={<NoPage/>}/>
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;