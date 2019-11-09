# HTML/CSS 速写神器 Emmet语法
## div#myid.myclass
- 生成带有 id 、class 的 HTML 标签
```html
<div id="myid" class="myclass"></div>
```
## div>ul
- 生成后代：>
```html
<div>
  <ul></ul>
</div>
```
## div+li
- 生成兄弟标签：+
```html
<div></div>
<l></l>i
```
## div>li>a^li
- 生成上级标签： ^
```html
<div>
  <li><a href=""></a></li>
  <li></li>
</div>
<div>
  <li><a href=""></a></li>
</div>
<li></li>
```
## ui>li*5
- 重复生成多个标签 *
```html
<ui>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
</ui>
```
## ui>(li>a)*5
- 生成分组的标签: ()
```html
<ui>
  <li><a href=""></a></li>
  <li><a href=""></a></li>
  <li><a href=""></a></li>
  <li><a href=""></a></li>
  <li><a href=""></a></li>
</ui>
```
## ui>li>a*5
   - 注意和ul>li>a*5 生成是不一样的
```html
<ui>
  <li>
    <a href=""></a>
    <a href=""></a>
    <a href=""></a>
    <a href=""></a>
    <a href=""></a>
  </li>
</ui>
```

## ui>li.item$*5
- 生成递增的属性标签等: $
```html
<ui>
  <li class="item1"></li>
  <li class="item2"></li>
  <li class="item3"></li>
  <li class="item4"></li>
  <li class="item5"></li>
</ui>
```


## ui>li.item$$*4
- 生成多位递增 $$
```html
<ui>
  <li class="item01"></li>
  <li class="item02"></li>
  <li class="item03"></li>
  <li class="item04"></li>
</ui>
```
## ui>li.item$@-*6
- 要生成递减的：@-
```html
<ui>
  <li class="item6"></li>
  <li class="item5"></li>
  <li class="item4"></li>
  <li class="item3"></li>
  <li class="item2"></li>
  <li class="item1"></li>
</ui>
```
## ui>li.time$@10*6
- 某个特定的顺序开始：@N
```html
<ui>
  <li class="time10"></li>
  <li class="time11"></li>
  <li class="time12"></li>
  <li class="time13"></li>
  <li class="time14"></li>
  <li class="time15"></li>
</ui>
```
## ui>li.time$@-10*6
- 逆序生成到某个数：@-
```html
<ui>
  <li class="time15"></li>
  <li class="time14"></li>
  <li class="time13"></li>
  <li class="time12"></li>
  <li class="time11"></li>
  <li class="time10"></li>
</ui>
```

## #id1+#id2
- 元素:可以不用输入div；#生成id
```html
<div id="id1"></div>
<div id="id2"></div>
```
## .class1+.class2
- 元素: 可以不用输入div; .生成class
```html
<div class="class1"></div>
<div class="class2"></div>
```
## ul>.time*2 
-  ul>li.time*2  根据父标签进行判定
```html
<ul>
  <li class="time"></li>
  <li class="time"></li>
</ul>
```

下面是所有的隐式标签名称：
li：用于 ul 和 ol 中
tr：用于 table、tbody、thead 和 tfoot 中
td：用于 tr 中
option：用于 select 和 optgroup 中
## p{我是文字内容}
```html
<p>我是文字内容</p>
```

## html:5
>  ! 生成 HTML5 结构

## img[http://www.a.com/logo.gif]
- 生成图片标签
```html
<img src="http://www.a.com/logo.gif" alt="">
```
