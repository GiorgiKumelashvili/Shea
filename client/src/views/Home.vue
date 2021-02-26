<template>
    <h1>Home</h1>
    <button @click="print">open</button>

    <div class="bg-light d-flex justify-content-between" style="width:15rem;font-size:2rem">
        <a download="file1.txt" id="dow1">text</a>
        <a download="file1.csv" id="dow2">csv</a>
        <a download="file1.json" id="dow3">json</a>
        <a download="file1.pdf" id="dow4">pdf</a>

        <button @click="downloadText">
            text
        </button>
    </div>
</template>

<script>
import { onMounted } from 'vue';
export default {
    setup() {
        const print = () => {
            let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');
            if (mywindow) {
                mywindow.document.write(`<html><head><title>giogg</title>`);
                mywindow.document.write('</head><body >');
                mywindow.document.write('hi');
                // mywindow.document.write(document.getElementById(divId).innerHTML);
                mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/

                mywindow.print();

                // return true;
            }
        };

        const downloadText = () => {
            var a = document.createElement('a');
            var blob = new Blob(['hello'], { type: 'text/plain' });
            a.href = window.URL.createObjectURL(blob);
            a.download = 'filename.txt';
            a.click();
        };

        onMounted(() => {
            const x = document.querySelector('#dow1');
            const y = document.querySelector('#dow2');
            const z = document.querySelector('#dow3');
            const o = document.querySelector('#dow4');

            let json = {
                number: true
            };

            const blob = new Blob([JSON.stringify(json)], { type: 'application/json' });
            [y, z].forEach(dom => (dom.href = URL.createObjectURL(blob)));

            const blob1 = new Blob(['<h1>hello</h1>'], { type: 'application/octet-stream' });
            // const blob1 = new Blob(['<h1>hello</h1>', 'wh'], { type: 'text/html' });
            x.href = URL.createObjectURL(blob1);
        });

        return { print, downloadText };
    }
};
</script>
