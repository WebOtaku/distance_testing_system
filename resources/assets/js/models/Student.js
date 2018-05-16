class Student {
    static fetch(then) {
        return axios.get('/student')
            .then(response => then(response.data[0]))
    }
}

export default Student;