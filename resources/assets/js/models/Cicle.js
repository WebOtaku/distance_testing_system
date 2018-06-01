class Discipline {
    static fetchAll(then) {
        return axios.get('/cicles')
            .then(response => then(response.data));
    }
}

export default Discipline;