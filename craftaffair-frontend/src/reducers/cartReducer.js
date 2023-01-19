const initialState = {
    sub_total : 0,
    tax_amount : 0,
    total_price : 0,
    items : []
}
const cartReducer = (state = initialState, action) => {
    switch(action.type){
        case 'UPDATE_CART_PRICE': return {
                ...state, ...action.payload
            }
        default:
            return state
    }
}
export default cartReducer;