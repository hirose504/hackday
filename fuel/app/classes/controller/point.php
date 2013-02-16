<?php
class Controller_Point extends Controller_Template 
{

	public function action_index()
	{
		$data['points'] = Model_Point::find('all');
		$this->template->title = "Points";
		$this->template->content = View::forge('point/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Point');

		if ( ! $data['point'] = Model_Point::find($id))
		{
			Session::set_flash('error', 'Could not find point #'.$id);
			Response::redirect('Point');
		}

		$this->template->title = "Point";
		$this->template->content = View::forge('point/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Point::validate('create');
			
			if ($val->run())
			{
				$point = Model_Point::forge(array(
					'line_id' => Input::post('line_id'),
					'point' => Input::post('point'),
				));

				if ($point and $point->save())
				{
					Session::set_flash('success', 'Added point #'.$point->id.'.');

					Response::redirect('point');
				}

				else
				{
					Session::set_flash('error', 'Could not save point.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Points";
		$this->template->content = View::forge('point/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Point');

		if ( ! $point = Model_Point::find($id))
		{
			Session::set_flash('error', 'Could not find point #'.$id);
			Response::redirect('Point');
		}

		$val = Model_Point::validate('edit');

		if ($val->run())
		{
			$point->line_id = Input::post('line_id');
			$point->point = Input::post('point');

			if ($point->save())
			{
				Session::set_flash('success', 'Updated point #' . $id);

				Response::redirect('point');
			}

			else
			{
				Session::set_flash('error', 'Could not update point #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$point->line_id = $val->validated('line_id');
				$point->point = $val->validated('point');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('point', $point, false);
		}

		$this->template->title = "Points";
		$this->template->content = View::forge('point/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Point');

		if ($point = Model_Point::find($id))
		{
			$point->delete();

			Session::set_flash('success', 'Deleted point #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete point #'.$id);
		}

		Response::redirect('point');

	}


}