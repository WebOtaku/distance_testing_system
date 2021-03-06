class Student {
    static fetch(userId, then) {
        return axios.get(`/students/${userId}`)
            .then(response => then(response.data));
    }
}

export default Student;
