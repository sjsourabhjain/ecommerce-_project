export const doLogin = (userDetails) => {
    return {
        type: 'DO_LOGIN',
        payload: userDetails
    }
}
export const doLogout = (userDetails) => {
    return {
        type: 'DO_LOGOUT',
        payload: userDetails
    }
}