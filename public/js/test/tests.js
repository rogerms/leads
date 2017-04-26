/**
 * Created by Roger on 4/24/2017.
 */
QUnit.module('general');
QUnit.test( "hello test", function( assert ) {
    assert.ok( 1 == "1", "Passed!" );
});

QUnit.test("getDate", function (assert) {
    var num = 3;
    var result = getDate('today');
    assert.equal(result.getDate(), new Date().getDate(),  "today's date is correct");
});