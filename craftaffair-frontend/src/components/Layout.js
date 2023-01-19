import React from 'react';
import Header from './Header';
import Footer from './Footer';

const Layout = (props) => {
    return(
            <>
                <Header/>
                    {props.component }
                <Footer/>
            </>
        )   
}
export default Layout;