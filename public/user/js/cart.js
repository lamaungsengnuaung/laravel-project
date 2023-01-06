
$('document').ready(function () {
    // increase qty and price
    $('.btn-plus').click(function () {
        $parentNode = $(this).parents("tr");
        $qty = $parentNode.find("#qty").val();
        // console.log($parentNode);
        Calculation();
        Summary();

    })
    // reduce qty and price
    $('.btn-minus').click(function () {
        $parentNode = $(this).parents("tr");
        $qty = $parentNode.find("#qty").val();
        if ($qty == 0) {
            $parentNode.remove();
        }
        Calculation();
        Summary();
    })
    // remove btn
    $('.btn-remove').click(function () {
        $parentNode = $(this).parents("tr");

        // $Id = $parentNode.
        $parentNode.remove();
        Summary();
        $.ajax({
            type: 'get',
            url: 'http://127.0.0.1:8000/user/ajax/clear/currentProduct',
            data: {
                'cart_id': $parentNode.find('#cartId').val(),
            },

            dataType: 'json',
        })
    })
    // delete whole Cart
    $('#btnClearC').click(function () {
        $('#tBody tr').remove();
        $sum = 0;
        $("#subtotal").text($sum + "Ks");
        $delivery = 3000;
        $("#totalcost").text($sum + $delivery + "Ks");
        $.ajax({
            type: 'get',
            url: 'http://127.0.0.1:8000/user/ajax/clear/cart',
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    window.location.href = "http://127.0.0.1:8000/user/homePage";
                }
            }
        })
    })


    function Calculation() {
        $price = $parentNode.find("#price").text().replace("Ks", " ");
        $price = Number($price);
        $totalPrice = $qty * $price;
        $parentNode.find("#totalPrice").text($totalPrice + " Ks");
    }

    function Summary() {
        $sum = 0;
        $('#tBody tr').each(function (index, row) {
            $sum = $sum + Number($(row).find('#totalPrice').html().replace("Ks", " "));
        })
        $("#subtotal").text($sum + "Ks");
        $delivery = 3000;
        $("#totalcost").text($sum + $delivery + "Ks");
    }
})
