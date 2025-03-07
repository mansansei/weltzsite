const openbtn = document.querySelector('#openregnewadmin');
const dialog = document.querySelector('#regadmindialog');
const closebtn = document.querySelector('#closeradbtn')

openbtn.addEventListener('click', () => dialog.showModal());
closebtn.addEventListener('click', () => dialog.close());