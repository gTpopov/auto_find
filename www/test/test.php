<script>

    function isNotMax(e){
        e = e || window.event;
        var target = e.target || e.srcElement;
        var code=e.keyCode?e.keyCode:(e.which?e.which:e.charCode)

        switch (code){
            case 13:
            case 8:
            case 9:
            case 46:
            case 37:
            case 38:
            case 39:
            case 40:
            return true;
        }

        return target.value.length <= target.getAttribute('maxlength');
    }

    function CalculateChars(TextElementId, CaptionElementId) {
        var s = document.getElementById(TextElementId).value;
        document.getElementById(CaptionElementId).innerHTML = 15-s.length;
    }

</script>


<textarea id="txtMessage" rows="10" cols="25"
          maxlength="15"
          onkeyup="CalculateChars('txtMessage', 'txtCharCount')"
          onkeypress="return isNotMax(event)">
</textarea>
<span id="txtCharCount">15</span>


