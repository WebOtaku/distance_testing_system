const languages = {
    en: {
        pageLength: 'Page length ',
        pageInfo: 'Current #pageNumber# / #totalPage# （total #totalRow# records）',
        first: 'First',
        previous: '«',
        next: '»',
        last: 'Last'
    },
    ru: {
        pageLength: 'Показывать по ',
        pageInfo: 'Текущая стр. #pageNumber# / #totalPage# （всего #totalRow# записей）',
        first: 'Первая',
        previous: '«',
        next: '»',
        last: 'Последняя'
    }
};

const defaults = {
    totalRow: 0,
    pageSizeMenu: [10, 20, 50, 100],
    language: 'en',
    align: 'right'
};

export default {
    languages,
    defaults
};