export const updateCartPrice = (cartPriceDetails) => {
    return {
        type: 'UPDATE_CART_PRICE',
        payload: cartPriceDetails
    }
}