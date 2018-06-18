class AnswerVariant {
    static destroy(answerVariantId, then) {
        return axios.delete(`/answer-variants/${answerVariantId}`)
            .then(response => then(response.data));
    };
}

export default AnswerVariant;
