export const setCartItemInLocalStorage = (tempProducts) => {
    let sub_total = 0;
    let total = 0;

    for(let i=0;i<tempProducts.length;i++){
        let items = tempProducts[i].cartDetails;
        for(let j=0;j<items.length;j++){
            sub_total = parseInt(sub_total) + parseInt(items[j].variant_price * items[j].qty);
        }
    }

    total = sub_total + (0.18*sub_total);

    const cartData = {
        "sub_total" : sub_total,
        "total" : total,
        "items" : tempProducts
    }

    localStorage.setItem("localCartProducts",JSON.stringify(cartData));
}

export const getCartItemInLocalStorage = () => {
    let localStorageData = JSON.parse(localStorage.getItem("localCartProducts"));
    return localStorageData===null ? [] : localStorageData.items;
}

export const getCartDetailsFromLocalStorage = () => {
    let localStorageData = JSON.parse(localStorage.getItem("localCartProducts"));
    return localStorageData===null ? [] : localStorageData;
}

export const getLoginStateDetailsFromLocalStorage = () => {
    let localStorageData = JSON.parse(localStorage.getItem("loginDetails"));
    return localStorageData===null ? null : localStorageData;
}

export const setLoginStateDetailsFromLocalStorage = (initialState) => {
    localStorage.setItem("loginDetails",JSON.stringify(initialState));
}

export const removeCartDetailsFromLocalStorage = () =>{
    localStorage.removeItem("localCartProducts");
}