;(function ($) {
  $.fn.spinner = function (opts) {
    return this.each(function () {
      var defaults = {value:0, min:0}
      var options = $.extend(defaults, opts)
      var keyCodes = {up:38, down:40}
      var container = $('<div></div>')
      container.addClass('spinner')
      var textField = $(this).addClass('value').attr('maxlength', '2').val(options.value)
        .bind('keyup paste change', function (e) {
          var field = $(this)
          if (e.keyCode == keyCodes.up) changeValue(1)
          else if (e.keyCode == keyCodes.down) changeValue(-1)
          else if (getValue(field) != container.data('lastValidValue')) validateAndTrigger(field)
        })
      textField.wrap(container)

      var increaseButton = $('<button class="increase">+</button>').click(function () { changeValue(this,1) })
      var decreaseButton = $('<button class="decrease">-</button>').click(function () { changeValue(this,-1) })

      validate(textField)
      container.data('lastValidValue', options.value)
      textField.before(decreaseButton)
      textField.after(increaseButton)

      function changeValue(that,delta) {
        textField.val(getValue() + delta)
        validateAndTrigger(textField)
		//alert();
		spec_id=$(that).parent().parent().attr("gid")
		sid=$(that).parent().parent().attr("sid")


   var mycars=new Array()
    mycars[0]="5751"
   
    if(spec_id==mycars[0]&&textField.val()>1)
    {
        add_to_shop(spec_id,1,sid);
        alert("此商品限购一件！");
         textField.val(1);
    }
		add_to_shop(spec_id,textField.val(),sid);
	
      }
      function add_to_shop(spec_id, quantity,store_id)
		{	
			var url = '/index.php?app=cart&act=to_shop&spec_id='+spec_id+'&quantity='+quantity+'&store_id='+store_id;
			$.getJSON(url, '', function(data){
				if (data.done)
				{
					
					//window.location.href='index.php?app=cart';cart{$store_id}_amount
					//alert('#cart5_amount'+ data.retval.cart.store_id);
					if($('#p_count_'+ data.retval.cart.store_id).length)
					{
						$('#p_count_'+ data.retval.cart.store_id).text(data.retval.cart.quantity);
					}    
					if($('#yxwcart').length)
					{
						$('#yxwcart').text(data.retval.cart.totalcount);
					}
					if($('#cart'+data.retval.cart.store_id+'_amount').length)
					{
						$('#cart'+data.retval.cart.store_id+'_amount').html(price_format(data.retval.cart.amount));
					}
			
					
				   // $('.bold_num').text(data.retval.cart.kinds);
				   // $('.bold_mly').html(price_format(data.retval.cart.amount));
				  // $(".buynow .msg").slideDown().delay(5000).slideUp();
				}
				else
				{ 
					alert(data.msg);
          textField.val(quantity-1)
				}
			});
		}
      function validateAndTrigger(field) {
        clearTimeout(container.data('timeout'))
        var value = validate(field)
        if (!isInvalid(value)) {
          textField.trigger('update', [field, value])
        }
      }

      function validate(field) {
        var value = getValue()
        if (value <= options.min) decreaseButton.attr('disabled', 'disabled')
        else decreaseButton.removeAttr('disabled')
        field.toggleClass('invalid', isInvalid(value)).toggleClass('passive', value === 0)

        if (isInvalid(value)) {
          var timeout = setTimeout(function () {
            textField.val(container.data('lastValidValue'))
            validate(field)
          }, 500)
          container.data('timeout', timeout)
        } else {
          container.data('lastValidValue', value)
        }
        return value
      }

      function isInvalid(value) { return isNaN(+value) || value < options.min; }

      function getValue(field) {
        field = field || textField;
        return parseInt(field.val() || 0, 10)
      }
    })
  }
})(jQuery)