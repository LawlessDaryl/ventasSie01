<script>
    try {
        onScan.attachto('document', {
            suffixKeyCode: [13],
            onScan: function(barcode) {
                console.log(barcode)
                window.livewire.emit('scan-code', barcode)
            },
            onScanError: function(e) {
                console.log(e)
            }
        })
        console.log('Scanner ready!')

    } catch (e) {
        console.log('Error de lectura' + e)
    }
</script>
