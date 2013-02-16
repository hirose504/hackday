<?php
class Controller_Line extends Controller_Template 
{

	public function action_index()
	{
		$data['lines'] = Model_Line::find('all');
		$this->template->title = "Lines";
		$this->template->content = View::forge('line/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Line');

		if ( ! $data['line'] = Model_Line::find($id))
		{
			Session::set_flash('error', 'Could not find line #'.$id);
			Response::redirect('Line');
		}

		$this->template->title = "Line";
		$this->template->content = View::forge('line/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Line::validate('create');
			
			if ($val->run())
			{
				$line = Model_Line::forge(array(
					'name' => Input::post('name'),
					'line' => Input::post('line'),
				));

				if ($line and $line->save())
				{
					Session::set_flash('success', 'Added line #'.$line->id.'.');

					Response::redirect('line');
				}

				else
				{
					Session::set_flash('error', 'Could not save line.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Lines";
		$this->template->content = View::forge('line/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Line');

		if ( ! $line = Model_Line::find($id))
		{
			Session::set_flash('error', 'Could not find line #'.$id);
			Response::redirect('Line');
		}

		$val = Model_Line::validate('edit');

		if ($val->run())
		{
			$line->name = Input::post('name');
			$line->line = Input::post('line');

			if ($line->save())
			{
				Session::set_flash('success', 'Updated line #' . $id);

				Response::redirect('line');
			}

			else
			{
				Session::set_flash('error', 'Could not update line #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$line->name = $val->validated('name');
				$line->line = $val->validated('line');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('line', $line, false);
		}

		$this->template->title = "Lines";
		$this->template->content = View::forge('line/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Line');

		if ($line = Model_Line::find($id))
		{
			$line->delete();

			Session::set_flash('success', 'Deleted line #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete line #'.$id);
		}

		Response::redirect('line');

	}


}