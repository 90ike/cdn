<?php if(_hui( 'sinaimg_s')){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#insert_img").click(function() {
				if ($('#img_title').val()) {
					var img_title = $('#img_title').val()
				} else {
					var img_title = $('#title').val()
				}
				if ($('#img_alt').val()) {
					var img_alt = $('#img_alt').val()
				} else {
					var img_alt = $('#title').val()
				}
				if ($('#url').val()) {
					obj = document.getElementById("content");
					obj.value += "<img src=\"" + ($('#url').val()) + "\" width=\"" + ($('#img_width').val()) + "\" height=\"" + ($('#img_height').val()) + "\">\r\n"
				} else {
					alert('未上传图片')
				}
				if ($('#url').val()) {
					if (showdiv_display = document.getElementById('content').style.display == 'none') {
						$('#ins_img')[0].innerHTML = '请先转到文本编辑模式'
					} else if (showdiv_display = document.getElementById('mceu_33').style.display == 'none') {
						$('#ins_img')[0].innerHTML = '重新上传'
					}
				}
			})
		});
	</script>
	<input type="file" id="file" style="display:none">
	<button type="button" class="button button-primary" id="ins_img" onclick="file.click()">
		新浪图床上传
	</button>
	<span id="texts">
	</span>
	<img id="img" style="height:30px;margin-top:-5px;display:none">
	<span id="insert_img" class="button" style="display:none">
		插入图片
	</span>
	<input type="text" id="img_width" name="img_width" placeholder="宽度" style="display:none">
	<input type="text" id="img_height" name="img_height" placeholder="高度"
	style="display:none">
	<script>
		$(document).ready(function() {
			$('.picurl > input').bind('focus mouseover',
			function() {
				if (this.value) {
					this.select()
				}
			});
			$("input[type='file']").change(function(e) {
				images_upload(this.files)
			});
			var obj = $('body');
			obj.on('dragenter',
			function(e) {
				e.stopPropagation();
				e.preventDefault()
			});
			obj.on('dragover',
			function(e) {
				e.stopPropagation();
				e.preventDefault()
			});
			obj.on('drop',
			function(e) {
				e.preventDefault();
				images_upload(e.originalEvent.dataTransfer.files)
			})
		});
		var images_upload = function(files) {
			var flag = 0;
			$(files).each(function(key, value) {
				$('#ins_img')[0].innerHTML = '上传中...';
				image_form = new FormData();
				image_form.append('file', value);
				console.log(image_form);
				$.ajax({
					url: jsui.www + '/sinaimg?type=multipart',
					type: 'POST',
					data: image_form,
					mimeType: 'multipart/form-data',
					contentType: false,
					cache: false,
					processData: false,
					dataType: 'json',
					success: function(data) {
						if (data.code == '200') {
							flag++;
							if (typeof data.pid != 'null') {
								$("#texts").html('<input type="text" id="url" value="https://ww2.sinaimg.cn/large/' + data['pid'] + '">');
								$("#img_width").val(data['width'] + 'px');
								$("#img_height").val(data['height'] + 'px');
								$("#img").attr('src', 'https://ww2.sinaimg.cn/large/' + data['pid']);
								$("#img").show();
								$("#insert_img").show()
							}
							if (flag == $("input[type='file']")[0].files.length) {
								if (typeof data.pid != 'null') {
									$('#ins_img')[0].innerHTML = '重新上传'
								} else {
									$('#ins_img')[0].innerHTML = '上传失败';
									alert('上传出错，请联系QQ1452938190')
								}
							}
						} else {
							alert(data.msg);
							$('#ins_img')[0].innerHTML = '上传失败'
						}
					},
					error: function(XMLResponse) {
						$('#ins_img')[0].innerHTML = '上传失败';
						alert("error:" + XMLResponse.responseText)
					}
				})
			})
		};
		document.onpaste = function(e) {
			var data = e.clipboardData;
			for (var i = 0; i < data.items.length; i++) {
				var item = data.items[i];
				if (item.kind == 'file' && item.type.match(/^image\//i)) {
					var blob = item.getAsFile();
					images_upload(blob)
				}
			}
		}
	</script>
	<script>
		window.jsui = {
			www: '<?php echo home_url() ?>'
		};
	</script>
	<?php } ?>