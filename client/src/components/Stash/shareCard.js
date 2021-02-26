import { ref } from 'vue';

const shareCardData = ref(null);
const copyValue = ref('Placeholder');

const saveShareCardData = obj => {
    shareCardData.value = JSON.parse(JSON.stringify(obj));
    refreshCopy();
};

const removeItemInShare = id => {
    let index = shareCardData.value.child.findIndex((el, i) => {
        if (el.id === id) return i;
    });
    index = index === -1 ? 0 : index;
    shareCardData.value.child.splice(index, 1);

    refreshCopy();
};

const prettyPrint = (name, child) => {
    // Header pretify
    let str = child.length ? `${name}\n${'='.repeat(name.length)}\n` : name;

    // Body pretify
    child.forEach(el => (str += `\tName\t: ${el.name} \n\tUrl\t\t: ${el.url}\n\n`));

    return str;
};

const refreshCopy = () => {
    const { child, name } = shareCardData.value;
    copyValue.value = prettyPrint(name, child);
};

const copyItemShareData = () => {
    const testingCodeToCopy = document.querySelector('#copy-item-share');
    testingCodeToCopy.setAttribute('type', 'text'); // hidden
    testingCodeToCopy.select();
    document.execCommand('copy');
    testingCodeToCopy.setAttribute('type', 'hidden');
    window.getSelection().removeAllRanges();
};

export default {
    shareCardData,
    copyValue,

    saveShareCardData,
    removeItemInShare,
    copyItemShareData
};
