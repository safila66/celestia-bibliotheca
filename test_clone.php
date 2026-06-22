<?php
class A {
    public function b() { return $this; }
    public function c() { return "hello"; }
}
$obj = new A();
$val = clone $obj->b()->c();
echo $val;
