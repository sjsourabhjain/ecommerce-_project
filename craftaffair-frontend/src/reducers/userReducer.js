const initialState = {
    isLoggedIn : 0,
    mobile_no : '',
    email: '',
    authToken : '',
    userId : 0
}

const userReducer = (state = initialState, action) => {
    switch(action.type){
        case 'DO_LOGIN': return {
                ...state, ...action.payload
            }
        case 'DO_LOGOUT':return {
                ...state, ...action.payload
            }
        default:
            return state
    }
}
export default userReducer;