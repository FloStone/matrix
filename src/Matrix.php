<?php

namespace Luba;

use IteratorAggregate, JsonSerializable, ArrayIterator;

class Matrix implements IteratorAggregate, JsonSerializable
{
	/**
	 * Matrix
	 * @var array
	 */
	protected $matrix = [];

	/**
	 * Constructor
	 * @param array $matrix
	 */
	public function __construct(array $matrix = [])
	{
		$this->matrix = $matrix;
	}

	/**
	 * Rotate the matrix 90 degrees
	 * @return Matrix
	 */
	public function rotate()
	{
		$rotated = new self();

		foreach ($this->matrix as $y => $row)
		{
			foreach ($row as $x => $value)
			{
				$rotated->set($y, $x, $value);
			}
		}

		return $rotated;
	}

	/**
	 * Get the matrix width
	 * @return int
	 */
	public function width()
	{
		return isset($this->matrix[0]) ? sizeof($this->matrix[0]) : 0;
	}

	/**
	 * get the matrix height
	 * @return int
	 */
	public function height()
	{
		return sizeof($this->matrix);
	}

	/**
	 * Get an element of the matrix
	 * @param  int $x
	 * @param  int $y
	 * @return int|string|bool|object
	 */
	public function get($x, $y)
	{
		return isset($this->matrix[$y]) ? isset($this->matrix[$y][$x]) ? $this->matrix[$y][$x] : null : null;
	}

	/**
	 * Set something into the matrix
	 * @param int $x
	 * @param int $y
	 * @param anything $value
	 */
	public function set($x, $y, $value)
	{
		$this->matrix[$y][$x] = $value;

		return $this;
	}

	/**
	 * Set a row in the matrix
	 * @param int $y
	 * @param array  $row
	 */
	public function setRow($y, array $row)
	{
		$this->matrix[$y] = $row;

		return $this;
	}

	/**
	 * Remove an items from the matrix
	 * @param  int $x
	 * @param  int $y
	 * @return void
	 */
	public function remove($x, $y)
	{
		$this->set($x, $y, null);

		return $this;
	}

	/**
	 * Get a full row of the matrix
	 * @param  int $y
	 * @return array
	 */
	public function getRow($y)
	{
		return $this->matrix[$y];

		return $this;
	}

	/**
	 * Remove a complete row of the matrix
	 * @param int $key
	 */
	public function removeRow($key)
	{
		unset($this->matrix[$key]);

		return $this;
	}

	/**
	 * Reset the matrix keys
	 * @return this
	 */
	public function reset()
	{
		foreach ($this->matrix as $y => $row)
		{
			$this->matrix[$y] = array_values($this->matrix[$y]);
		}

		$this->matrix = array_values($this->matrix);

		return $this;
	}

	/**
	 * Remove a complete column in the matrix
	 * @param  int $key
	 * @return void
	 */
	public function removeCol($key)
	{
		foreach ($this->matrix as $k => $row)
		{
			unset($this->matrix[$k][$key]);
		}

		$this->reset();

		return $this;
	}

	/**
	 * Set a column in the matrix
	 * @param int $x
	 * @param array  $column
	 */
	public function setColumn($x, array $column)
	{
		for ($i = 0; $i < $this->height(); $i++)
		{
			$this->set($x, $i, $column[$i]);
		}

		return $this;
	}

	/**
	 * Get a complete column of the matrix
	 * @param  int $x
	 * @return array
	 */
	public function getColumn($x)
	{
		return $this->rotate->getRow($x);
	}

	/**
	 * String representation
	 * @return string
	 */
	public function __toString()
	{
		$matrix = "";

		foreach ($this->matrix as $col)
		{
			foreach ($col as $row)
			{
				$matrix .= "$row ";
			}
			$matrix = trim($matrix) . "\n";
		}

		return $matrix;
	}

	/**
	 * Array iterator
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->matrix);
	}

	/**
	 * Json serialization
	 * @return json
	 */
	public function jsonSerialize()
	{
		return json_encode($this->matrix);
	}
}