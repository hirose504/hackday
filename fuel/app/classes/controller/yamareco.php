<?php
class Controller_Yamareco extends Controller_Template 
{

	public function action_index()
	{
		$data['yamarecos'] = Model_Yamareco::find('all');
		$this->template->title = "Yamarecos";
		$this->template->content = View::forge('yamareco/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Yamareco');

		if ( ! $data['yamareco'] = Model_Yamareco::find($id))
		{
			Session::set_flash('error', 'Could not find yamareco #'.$id);
			Response::redirect('Yamareco');
		}

		$this->template->title = "Yamareco";
		$this->template->content = View::forge('yamareco/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Yamareco::validate('create');
			
			if ($val->run())
			{
				$yamareco = Model_Yamareco::forge(array(
					'name' => Input::post('name'),
					'line' => Input::post('line'),
					'time' => Input::post('time'),
				));

				if ($yamareco and $yamareco->save())
				{
					Session::set_flash('success', 'Added yamareco #'.$yamareco->id.'.');

					Response::redirect('yamareco');
				}

				else
				{
					Session::set_flash('error', 'Could not save yamareco.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Yamarecos";
		$this->template->content = View::forge('yamareco/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Yamareco');

		if ( ! $yamareco = Model_Yamareco::find($id))
		{
			Session::set_flash('error', 'Could not find yamareco #'.$id);
			Response::redirect('Yamareco');
		}

		$val = Model_Yamareco::validate('edit');

		if ($val->run())
		{
			$yamareco->name = Input::post('name');
			$yamareco->line = Input::post('line');
			$yamareco->time = Input::post('time');

			if ($yamareco->save())
			{
				Session::set_flash('success', 'Updated yamareco #' . $id);

				Response::redirect('yamareco');
			}

			else
			{
				Session::set_flash('error', 'Could not update yamareco #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$yamareco->name = $val->validated('name');
				$yamareco->line = $val->validated('line');
				$yamareco->time = $val->validated('time');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('yamareco', $yamareco, false);
		}

		$this->template->title = "Yamarecos";
		$this->template->content = View::forge('yamareco/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Yamareco');

		if ($yamareco = Model_Yamareco::find($id))
		{
			$yamareco->delete();

			Session::set_flash('success', 'Deleted yamareco #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete yamareco #'.$id);
		}

		Response::redirect('yamareco');

	}


}