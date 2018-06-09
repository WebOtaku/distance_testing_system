class User {
    static fetch(userId, then) {
        return axios.get(`/users/${userId}`)
            .then(response => then(response.data))
    }
}

export default User;
