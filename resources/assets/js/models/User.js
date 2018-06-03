class User {
    static fetch(then) {
        return axios.get('/users')
            .then(response => then(response.data))
    }
}

export default User;
