<?php

use Comodojo\Cookies\Cookies;

require '../vendor/autoload.php';

ob_start();

echo '<h1>Comodojo::Cookies tests - SET </h1>';

echo '<p>Setting plain cookie (default values)... ';

$result = Cookies::set("Lorem ipsum dolor sit amet...");

echo $result ? '<span style="color: green;"> done!</span>' : '<span style="color: red;"> failed!</span>';

echo '</p>';

echo '<p>Setting encrypted cookie (default values)... ';

$result = Cookies::set(array("name" => "comodojo_encrypted", "value" => "Lorem ipsum dolor sit amet..."), "thisismyverycomplexpassword");

echo $result ? '<span style="color: green;"> done!</span>' : '<span style="color: red;"> failed!</span>';

echo '</p>';

echo '<p>Setting array in a plain cookie...';

$result = Cookies::set(array("name" => "comodojo_array", "value" => array("Lorem", "ipsum", "dolor", "sit", "amet")));

echo $result ? '<span style="color: green;"> done!</span>' : '<span style="color: red;"> failed!</span>';

echo '</p>';

echo '<p>Setting array in encrypted cookie...';

$result = Cookies::set(array("name" => "comodojo_encrypted_array", "value" => array("sed", "aliqua", "mentor", "partum", "differo")), "thisismyverycomplexpassword");

echo $result ? '<span style="color: green;"> done!</span>' : '<span style="color: red;"> failed!</span>';

echo '</p>';

echo '<p>Setting 10 seconds valid cookie...';

$result = Cookies::set(array("name" => "comodojo_short_cookie", "value" => "10 secs to live only", "expire" => time() + 10));

echo $result ? '<span style="color: green;"> done!</span>' : '<span style="color: red;"> failed!</span>';

echo '</p>';

echo '<p>Setting cookie > 4K (should throw exception): ';

try {

	$result = Cookies::set(array("name" => "comodojo_big_cookie", "value" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dapibus congue quam eu suscipit. Donec id lobortis urna, quis viverra diam. Nulla ante enim, semper a dictum aliquet, tristique a velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut et fringilla sem. Nunc iaculis turpis id turpis faucibus egestas. Vestibulum lorem est, tempus sed lobortis ac, tristique sed nulla. Nulla lectus erat, sodales sed quam non, aliquam condimentum ligula. Sed non cursus neque. Cras a mi ut tellus semper convallis. Aenean ullamcorper sed leo a facilisis. Suspendisse luctus lorem libero, venenatis facilisis lectus tincidunt vel. Maecenas varius eleifend ipsum, nec viverra ligula facilisis quis. In hac habitasse platea dictumst. Aenean eget laoreet ipsum. In mi mi, consequat tempus hendrerit a, porta in neque. Proin tincidunt, sem eu luctus molestie, ante dolor consequat dolor, in fringilla est eros et turpis. Suspendisse vitae tempus urna, eu iaculis velit. Nunc vel facilisis erat. Proin congue metus lacinia imperdiet fringilla. Etiam ut nisi a massa vestibulum euismod sed eget lorem. Donec quis congue augue. Aenean libero lectus, convallis quis elit eu, tristique porta lectus. Integer ac magna pellentesque, pretium ante porta, pharetra enim. Curabitur imperdiet, libero a porta euismod, lacus nisi maximus arcu, quis sodales ipsum mi ac erat. Praesent massa nunc, laoreet sed dui in, tincidunt tempus quam. Proin porta sem arcu, sit amet accumsan eros euismod nec. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin mattis at massa id dignissim. Morbi vehicula mattis lectus ac iaculis. Nulla ipsum dui, tempor a justo et, rhoncus finibus lectus. Morbi hendrerit mi in libero feugiat laoreet. Donec mollis, diam sit amet maximus bibendum, ante elit aliquet nunc, a finibus turpis ligula vel erat. Fusce ornare placerat ante non fermentum. Sed nec scelerisque orci. Nam euismod metus leo, sit amet ultricies elit luctus vitae. Sed bibendum lectus nec pretium ultricies. Ut a nunc ac diam facilisis pharetra. Mauris a velit ut diam tempus vestibulum quis at odio. Nullam aliquam quam sit amet lacus volutpat, id dignissim elit egestas. Morbi sit amet tellus non odio porttitor vestibulum in in felis. Curabitur pretium commodo ipsum non commodo. Vivamus dictum ex ac enim rutrum ornare. Aliquam dignissim volutpat purus dictum vestibulum. Aliquam laoreet metus eu augue rhoncus maximus. Fusce orci nibh, tempus pellentesque aliquet nec, congue id erat. Quisque sit amet lectus sit amet tellus finibus mattis. Nullam euismod egestas odio a accumsan. Etiam congue placerat leo nec laoreet. Mauris placerat, elit non pretium ultrices, erat mi egestas lacus, semper accumsan nisl felis vel augue. Nunc quis elementum magna, ut feugiat leo. In vulputate nibh eget lacus molestie laoreet. Phasellus varius elit a sem molestie, non tristique ligula sollicitudin. Proin vel finibus elit. Nam nunc tortor, pulvinar ut consectetur id, sagittis id libero. Aenean lobortis felis non lobortis scelerisque. Fusce venenatis urna id finibus eleifend. Sed lobortis sagittis tristique. Vestibulum at nisi at mi ullamcorper malesuada et viverra lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. In a quam sed neque volutpat accumsan id sit amet eros. Duis sed diam luctus, sodales sapien non, luctus quam. Donec ac posuere risus. Ut non aliquam purus. Donec ut fermentum sapien. Nullam nisl turpis, consequat id lacinia non, ultrices at erat. Quisque consequat dapibus odio, non lacinia nibh tempus in. Integer volutpat leo nulla, a porttitor lectus condimentum pulvinar. Praesent faucibus arcu at felis venenatis pretium. Duis ullamcorper neque enim, nec imperdiet eros eleifend eget. Suspendisse lectus enim, lobortis ut purus nec, egestas fringilla justo. Vestibulum facilisis nec nunc ac tempor. Pellentesque at nibh vitae purus rhoncus tincidunt. Morbi euismod consectetur porta. Ut ut felis id odio pellentesque convallis. Mauris ac metus eu ipsum ullamcorper sollicitudin eget sit amet quam nullam."), "thisismyverycomplexpassword");

} catch(\Exception $e) {

	echo '<span style="color: red;">'.$e->getMessage().'</span>';

}

ob_end_flush();