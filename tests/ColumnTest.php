<?php



class ColumnTest extends PHPUnit_Framework_TestCase
{
    public function createDataGrid(){
        return new \DataGrid\DataGrid();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorName()
    {
        $dg = $this->createDataGrid();
        new \DataGrid\Column($dg, null, 0);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorIndex()
    {
        $dg = $this->createDataGrid();
        new \DataGrid\Column($dg, "column", "not an integer");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNameAccessors()
    {
        $column = new \DataGrid\Column($this->createDataGrid(), "oldname", 0);
        $this->assertEquals("oldname", $column->getName());
        $column->setName("newname");
        $this->assertEquals("newname", $column->getName());
        $column->setName(array("test" => 1));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testActiveAccessors()
    {
        $column = new \DataGrid\Column($this->createDataGrid(), "column", 0);
        $this->assertEquals(true, $column->getActive(), 'a column is always active by default');
        $column->setActive(false);
        $this->assertEquals(false, $column->getActive());
        $column->setActive("string");
    }

    public function testCellAccessorAccessors()
    {
        //todo write test case
    }



}
