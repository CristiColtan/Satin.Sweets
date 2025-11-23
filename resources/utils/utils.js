function slugify(text) {
    return text
        .toString()
        .normalize('NFD') // elimină diacritice
        .replace(/[\u0300-\u036f]/g, '') // curăță diacriticele
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '') // scoate caractere speciale
        .replace(/\s+/g, '-') // înlocuiește spațiile cu -
        .replace(/-+/g, '-') // elimină multiplele liniuțe
}

export { slugify }
