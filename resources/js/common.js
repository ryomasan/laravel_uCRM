const getToday = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = ("0" + (today.getMonth() + 1)).slice(-2);
    const dd = ("0" + today.getDate()).slice(-2);
    return yyyy + '-' + mm + '-' + dd;
}

const getDate = (purchaseDate) => {
    const date = new Date(purchaseDate)
    const YYYY = date.getFullYear();
    const MM = ("0" + (date.getMonth() + 1)).slice(-2);
    const DD = ("0" + date.getDate()).slice(-2);
    // const HH = ("0" + date.getHours()).slice(-2);
    // const mm = ("0" + date.getMinutes()).slice(-2);
    // const ss = ("0" + date.getSeconds()).slice(-2);

    return YYYY + '/' + MM + '/' + DD;
}
export { getToday, getDate }