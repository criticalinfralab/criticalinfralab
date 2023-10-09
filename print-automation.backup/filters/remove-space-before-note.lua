local function is_space_before_note_in_text(spc, note)
  return spc and spc.t == 'Space'
    and note and note.t == 'Note'
end

function Inlines (inlines)
  -- Go from end to start to avoid problems with shifting indices.
  for i = #inlines-1, 1, -1 do
    if is_space_before_note_in_text(inlines[i], inlines[i+1]) then
      inlines:remove(i)
    end
  end
  return inlines
end
