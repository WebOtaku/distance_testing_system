class User {
    static fetch(then) {
        return axios.get('/user')
            .then(response => then(response.data))
    }
}

export default User;