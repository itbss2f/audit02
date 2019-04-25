;(function($){
	$.fn.extend({
		"addinput": function(o){
			o = $.extend({
				clicker: null, //������أ����Ը���class����id��ѡ��Ĭ��.next()��ȡ
				wrap: "li", //input�ĸ���ǩ
				name: "bigpic[]", //input��name
				type: "file", //input��type��Ĭ��text��
				value: "", //input��value
				maxlength: 250, //input��maxlength��Ĭ��20
				className: null, //input��className
				toplimit: 0, //����input�����ޣ�0��ʾ������
				initValue: null //��ʼ����ӵ�input��valueֵ�����������顣�����޸�ĳ����ʱ��ʾ���е�����
			}, o || {});
			//����һ�������洢����
			var $container = $(this);
			var i, len;

			//name���黯
			var arrName = new Array();
			if ( $.isArray(o.name) ) {
				arrName = o.name;
			} else {
				arrName.push(o.name);
			}
			var nLen = arrName.length;

			//type���黯
			var arrType = new Array();
			if ( $.isArray(o.type) ) {
				arrType = o.type;
			} else {
				//��ȫtype���飨����name���鳤�ȣ�
				for ( i = 0; i < nLen; i++ ) {
					arrType.push(o.type);
				}
			}
			var tLen = arrType.length;

			//value���黯
			var arrValue = new Array();
			if ( $.isArray(o.value) ) {
				arrValue = o.value;
			} else {
				//��ȫvalue���飨����name���鳤�ȣ�
				for ( i = 0; i < nLen; i++ ) {
					arrValue.push(o.value);
				}
			}
			var vLen = arrValue.length;

			//maxlength���黯
			var arrMaxlength = new Array();
			if ( $.isArray(o.maxlength) ) {
				arrMaxlength = o.maxlength;
			} else {
				//��ȫmaxlength���飨����name���鳤�ȣ�
				for ( i = 0; i < nLen; i++ ) {
					arrMaxlength.push(o.maxlength);
				}
			}
			var mLen = arrMaxlength.length;

			//class���黯
			var arrClass = new Array();
			if ( $.isArray(o.className) ) {
				arrClass = o.className;
			} else {
				//��ȫclass���飨����name���鳤�ȣ�
				for ( i = 0; i < nLen; i++ ) {
					arrClass.push(o.className);
				}
			}
			var cLen = arrClass.length;
			
			var oo = {
				remove: "<a href=\"#nogo\" class=\"remove\">�Ƴ�</a>",
				error1: "�������ô�������ĳ��Ȳ�һ�£����顣",
				error2: "�������ô���ÿ���ʼ��ֵ�����������飬���顣"
			}

			//����һ���������жϸ����鳤���Ƿ�һ�£�����ģ�
			var allowed = nLen != tLen || nLen != vLen || nLen != mLen || nLen != cLen ? false : true
			if ( !allowed ) {//�����һ��...
				$container.text(oo.error1);
				return false;
			}else{
				//��ȡ�������
				var $Clicker = !o.clicker ? $container.next() : $(o.clicker);
				$Clicker.bind("click", function() {
					//δ���ǰ������
					len = $container.children(o.wrap).length;
					//����һ���������ж��Ƿ��Ѿ��ﵽ����
					var isMax = o.toplimit === 0 ? false : (len < o.toplimit ? false : true);
					if ( !isMax ) {//û�дﵽ���޲��������
						var $Item = $("<"+ o.wrap +">").appendTo( $container );
						//����name����ĳ������input
						for ( i=0; i<nLen; i++ ) {
							$("<input>", {//jQuery1.4��������
								name: arrName[i],
								type: arrType[i],
								value: arrValue[i],
								maxlength: arrMaxlength[i],
								className: arrClass[i],
								size: "45"
							}).appendTo( $Item );
						}
						$Item = $container.children(o.wrap);
						//������
						len = $Item.length;
						if ( len > 1 ) {
							$Item.last().append(oo.remove);
							if ( len === 2 ) {//����һ��ʱ��Ϊ��һ����ӡ��Ƴ�����ť
								$Item.first().append(oo.remove);
							}
						}
						$Item.find(".remove").click(function(){
							//�Ƴ�����
							$(this).parent().remove();
							//ͳ��ʣ�µ�����
							len = $container.children(o.wrap).length;
							if ( len === 1 ) {//ֻʣһ����ʱ�򣬰ѡ��Ƴ�����ť�ɵ�
								$container.find(".remove").remove();
							}
							//ȡ�����Ƴ�����ť��Ĭ�϶���
							return false;
						});
					}
					//ȡ��������ص�Ĭ�϶���
					return false;
				});
				//��ʼ��
				if ( $.isArray(o.initValue) ) {//�ж��Ƿ������飨����ģ�
					$.each(o.initValue, function(i, n) {
						if ( !$.isArray(n) ) {
							$container.empty().text(oo.error2);
							return false;
						}
						//����һ��Ĭ��input
						$Clicker.click();
						//��ȡ������������
						$Item = $container.children(o.wrap).eq(i);
						$.each(n, function(j, m) {
							//ѭ������input��valueֵ
							$Item.children("input").eq(j).attr("value", m);
						});
					});
				}else{
					//û�����ó�ʼ��������һ��Ĭ��input
					$Clicker.click();
				}
			}
		}
	});
})(jQuery);