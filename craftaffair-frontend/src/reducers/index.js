import userReducer from './userReducer';
import cartReducer from './cartReducer';
import {combineReducers} from 'redux';
const allReducers = combineReducers({
    user: userReducer,
    cart: cartReducer
});
export default allReducers