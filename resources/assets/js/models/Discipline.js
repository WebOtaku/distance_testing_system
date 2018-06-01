class Discipline {
    static fetch(cicleId, then) {
        return axios.get(`/disciplines/${cicleId}`)
            .then(response => then(response.data));
    }
}

export default Discipline;