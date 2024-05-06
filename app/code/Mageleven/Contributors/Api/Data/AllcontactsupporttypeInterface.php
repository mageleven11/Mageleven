<?php
namespace Mageleven\Contributors\Api\Data;

interface AllcontactsupporttypeInterface
{
	const CS_ID = 'cs_id';
	const TYPE  = 'type';
	const STATUS = 'status';

	public function getId();

	public function getType();

	public function getStatus();

	public function setId($id);

	public function setType($type);

	public function setStatus($status);
}