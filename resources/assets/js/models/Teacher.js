class Teacher {
    static fetch(userId, then) {
        return axios.get(`/teachers/${userId}`)
            .then(response => then(response.data));
    }
}

export default Teacher;