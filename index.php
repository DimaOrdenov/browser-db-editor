<?php

require_once 'config.php';

$conn = new mysqli($DB_CONN['server'], $DB_CONN['username'], $DB_CONN['password'], $DB_CONN['db']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

/* Getting products */
$sql = "SELECT * FROM table_modify tm LEFT JOIN category c ON tm.category_id = c.category_id";

$result = $conn->query($sql) or die("Select failed: " . $conn->error);

while($row = $result->fetch_assoc()) {
	$data['rows'][] = array(
		'id'				=> $row['id'],
		'product_name'		=> $row['product_name'],
		'category_id'		=> $row['category_id'],
		'category_name'		=> $row['category_name'],
		'price'				=> number_format(floatval($row['price']), 2, '.', ''),
		);
}

/* Getting categories */
$sql = "SELECT * FROM category";

$result = $conn->query($sql) or die("Select failed: " . $conn->error);

while($row = $result->fetch_assoc()) {
	$data['categories'][] = array(
		'category_name'		=> $row['category_name'],
		);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Test task</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


		<link rel="stylesheet" type="text/css" href="css/main.css">

		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>
	<body>
		<div class="loader"></div>
		<div class="div-error"></div>
		<div id="dialog-form" title="Окно добавления новой записи" style="display: none;">
			<form>
				<div class="form-group">
					<label for="product">Название товара:</label>
					<input type="text" name="add[product]" id="product" class="form-control" required placeholder="Название товара" />
				</div>
				<div class="form-group">
					<label for="category">Категория:</label>
					<select name="add[category]" id="category" class="form-control">
						<option value="0">-</option>
						<?php foreach ($data['categories'] as $k => $category) : ?>
							<option value="<?php echo $k+1; ?>"><?php echo $category['category_name']; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="price">Стоимость:</label>
					<input type="text" name="add[price]" id="price" class="form-control" required placeholder="Стоимость" value="0.0" />
				</div>
				<div class="form-group">
					<p class="validateTips"></p>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr style="background-color: #ddd;">
							<th>ID</th>
							<th>Product</th>
							<th>Category</th>
							<th>Price</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php $rows = 0; ?>
						<?php foreach ($data['rows'] as $row) : ?>
							<tr id="row-<?php echo $rows; ?>">
								<td><?php echo $row['id']; ?></td>
								<td><input class="form-control form-control-addition" type="text" name="product" id="tab_product" value="<?php echo $row['product_name']; ?>"></td>
								<td>
									<select name="category" id="tab_category_id" class="form-control form-control-addition">
										<option value="0">-</option>
										<?php foreach ($data['categories'] as $k => $category) : ?>
											<option value="<?php echo $k+1; ?>" <?php if ($row['category_id'] == $k+1) : ?> selected <?php endif ?>><?php echo $category['category_name']; ?></option>
										<?php endforeach ?>
									</select>
								</td>
								<td><input class="form-control form-control-addition" type="text" name="price" id="tab_price" value="<?php echo $row['price']; ?>"></td>
								<td class="text-right">
									<button name="del-row" value="<?php echo $row['id']; ?>" type="button" class="btn btn-danger btn-sm" title="Удалить запись">Удалить запись</button>
								</td>
								<input id="tab_id" type="hidden" name="id[]" value="<?php echo $row['id']; ?>" />
							</tr>
							<?php $rows++; ?>
						<?php endforeach ?>
					</tbody>
				</table>
				<button id="add-row" type="button" class="btn btn-primary" title="Добавить запись">Добавить запись</button>
			</div>
		</div>

		<script type="text/javascript">
			$( function() {
				$( document ).tooltip();
			} );

			var dialog, form;
			var rows = <?php echo $rows; ?>;

			$( function() {
				var product = $( "#product" ),
					category = $( "#category" ),
					price = $( "#price" ),
					allFields = $( [] ).add( product ).add( category ).add( price ),
					tips = $( ".validateTips" );

				function updateTips( t ) {
					tips.text( t ).addClass( "ui-state-highlight" );
					setTimeout(function() {
						tips.removeClass( "ui-state-highlight" );
					}, 500 );
				}

				function checkLength( o, n, min, max ) {
					if ( o.val().length > max || o.val().length < min ) {
						o.addClass( "ui-state-error" );
						updateTips( "Поле '" + n + "' должно быть больше " + min + " и меньше " + max + "!" );
						return false;
					} else {
						return true;
					}
				}

				function checkRegexp( o, regexp, n ) {
					if ( !( regexp.test( o.val() ) ) ) {
						o.addClass( "ui-state-error" );
						updateTips( n );
						return false;
					} else {
						return true;
					}
				}

				function checkSelect( o, n ) {
					if ( o.val() == "0" ) {
						o.addClass( "ui-state-error" );
						updateTips( n );
						return false;
					} else {
						return true;
					}
				}

				function addRow() {
					var valid = true;
					allFields.removeClass( "ui-state-error" );
					tips.html('');

					valid = valid && checkLength( product, "Название товара", 3, 50 );
					valid = valid && checkLength( price, "Стоимость", 0, 13 );

					valid = valid && checkRegexp( product, /^[а-яa-z]([0-9а-яa-z_\s])+$/i, "Название товара может содержать буквы, цифры, нижние подчеркивания, пробелы и должно начинаться с буквы!" );
					valid = valid && checkSelect (category, "Выберите категорию!");
					valid = valid && checkRegexp( price, /^[0-9]+\.[0-9]([0-9])?$/, "Стоиость должна иметь формат числа с плавающей точкой, максимум 10 знаков до точки и от 1 до 2 после! (0.0 - 999999999.99)" );

					if ( valid ) {
						$('.loader').fadeIn();
						$.ajax({
							url: 'ajax.php?action=add',
							type: 'post',
							data: $('#product, #category, #price'),
							dataType: 'json',
							success: function(json) {
								if (json['error']) {
									alert(json['error']);
								} else {
									var newRow = document.createElement('tr');
									newRow.id = "row-" + rows;

									var td_id = document.createElement('td');
									td_id.innerHTML = json.product_id;

									var td_prod = document.createElement('td');
									td_prod.innerHTML = '<input class="form-control form-control-addition" type="text" name="product" id="tab_product" value="' + product.val() + '">';

									var td_cat = document.createElement('td');
									var td_cat_select = document.createElement('select');
									td_cat_select.setAttribute("name", "category");
									td_cat_select.setAttribute("id", "tab_category_id");
									td_cat_select.setAttribute("class", "form-control form-control-addition");
									var option = new Option("-", "0");
									td_cat_select.appendChild(option);
									<?php foreach ($data['categories'] as $k => $category) : ?>
										if (category.find(":selected").val() == "<?php echo $k+1; ?>") {
											var option = new Option("<?php echo $category['category_name']; ?>", "<?php echo $k+1; ?>", true, true);
										} else {
											var option = new Option("<?php echo $category['category_name']; ?>", "<?php echo $k+1; ?>", true, false);
										}
										td_cat_select.appendChild(option);
									<?php endforeach ?>
									td_cat.appendChild(td_cat_select);

									var td_price = document.createElement('td');
									td_price.innerHTML = '<input class="form-control form-control-addition" type="text" name="price" id="tab_price" value="' + parseFloat(price.val()).toFixed(2) + '">';

									var td_del = document.createElement('td');
									td_del.className = "text-right";
									td_del.innerHTML = '<button name="del-row" value="' + json.product_id + '" type="button" class="btn btn-danger btn-sm" title="Удалить запись">Удалить запись</button>';

									var hidden = document.createElement('input');
									hidden.setAttribute("id", "tab_id");
									hidden.setAttribute("type", "hidden");
									hidden.setAttribute("name", "id[]");
									hidden.setAttribute("value", json.product_id);

									newRow.appendChild(td_id);
									newRow.appendChild(td_prod);
									newRow.appendChild(td_cat);
									newRow.appendChild(td_price);
									newRow.appendChild(td_del);
									newRow.appendChild(hidden);

									$('tbody').append(newRow);

									dialog.dialog( "close" );

									$('#row-' + rows).addClass('change-success');

									$('#row-' + rows).removeClass("change-success", 1500);

									rows++;
								}
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert('Error in AJAX! Watch console!');
								console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					}
					$('.loader').fadeOut();
					return valid;
				}

				dialog = $( "#dialog-form" ).dialog({
					autoOpen: false,
					height: 500,
					width: 350,
					modal: true,
					draggable: false,
					resizable: false,
					buttons: {
						"Добавить запись": addRow,
						"Отмена": function() {
							form[ 0 ].reset();
							tips.html('');
							allFields.removeClass( "ui-state-error" );
							dialog.dialog( "close" );
						}
					},
					close: function() {
						form[ 0 ].reset();
						tips.html('');
						allFields.removeClass( "ui-state-error" );
					}
				});

				form = dialog.find( "form" ).on( "submit", function( event ) {
					event.preventDefault();
					addRow();
				});
			});

			$('#add-row').on('click', function () {
				dialog.dialog( "open" );
			});

			$(document.body).on('click', 'button[name=del-row]', function () {
				$('.loader').fadeIn();
				var rowButton = $(this);
				if (confirm("Вы уверены?")) {
					$.ajax({
						url: 'ajax.php?action=del',
						type: 'post',
						data: {
							'product_id': rowButton.val()
						},
						dataType: 'json',
						success: function(json) {
							if (json['error']) {
								alert(json['error']);
							} else {
								rowButton.closest('tr').remove();
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert('Error in AJAX! Watch console!');
							console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
				$('.loader').fadeOut();
			});

			$(document.body).on('focusin', '.container table tbody #tab_product, .container table tbody #tab_price', function () {
				$(this).data('val', $(this).val());
			});

			$(document.body).on('mouseenter', '.container table tbody #tab_category_id', function () {
				$(this).data('val', $(this).val());
			});

			$(document.body).on('change', '.container table tbody #tab_product, .container table tbody #tab_category_id, .container table tbody #tab_price', function () {
				var inputRow 	= 		$(this),
					inputRowVal =		$(this).val(),
					inputTR		= 		inputRow.closest('tr'),
					product_id 	= 		inputTR.find('#tab_id').val(),
					product 	= 		inputTR.find('#tab_product').val(),
					category 	= 		inputTR.find('#tab_category_id').val(),
					price 		= 		parseFloat(inputTR.find('#tab_price').val()).toFixed(2),
					prevVal		=		$(this).data('val');

				var valid = true;
				var regexpProduct = /^[а-яa-z]([0-9а-яa-z_\s])+$/i;
				var regexpPrice = /^[0-9]+\.[0-9]([0-9])?$/;

				if (inputRow.attr('id') == 'tab_product' && (inputRowVal.length < 3 || inputRowVal.length > 50 || !regexpProduct.test(inputRowVal))) {
					valid = valid && false;
					var error = "Название товара может содержать буквы, цифры, нижние подчеркивания, пробелы и должно начинаться с буквы! Длина названия должна быть от 3 до 50 символов!";
				}

				if (inputRow.attr('id') == 'tab_category_id' && inputRowVal == "0") {
					valid = valid && false;
					var error = "Выберите одну из существующих категорий!";
				}

				if (inputRow.attr('id') == 'tab_price' && (inputRowVal.length > 13 || !regexpPrice.test(inputRowVal))) {
					valid = valid && false;
					var error = "Стоимость должна иметь формат числа с плавающей точкой, максимум 10 знаков до точки и от 1 до 2 после! (0.0 - 999999999.99)";
				}

				if (valid) {
					$('.loader').fadeIn();
					$.ajax({
						url: 'ajax.php?action=edit',
						type: 'post',
						data: {
							'product_id': 	product_id,
							'product': 		product,
							'category_id': 	category,
							'price': 		price
						},
						dataType: 'json',
						success: function(json) {
							if (json['error']) {
								alert(json['error']);
							} else {
								if (inputRow.attr('id') == 'tab_price') inputRow.val(price);

								inputRow.addClass('change-success');

								setTimeout(function() {
									inputRow.removeClass("change-success", 1500);
								}, 500);
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert('Error in AJAX! Watch console!');
							console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				} else {
					inputRow.val(prevVal);
					inputRow.addClass('change-error');
					$('.div-error').html(error);
					$('.div-error').fadeIn();

					setTimeout(function() {
						inputRow.removeClass("change-error", 1500);
					}, 500);

					setTimeout(function() {
						$('.div-error').fadeOut();
					}, 2500);
				}
				$('.loader').fadeOut();
			});
		</script>
	</body>
</html>